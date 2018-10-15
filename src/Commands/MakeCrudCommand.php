<?php

namespace WRonX\LumenCrudGenerator\Commands;

use Illuminate\Console\Command;
use WRonX\LumenCrudGenerator\Enums\StubType;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud
                            {model : Model class name}
                            {--r|create-routes : Add CRUD routes to routes file}
                            {--w|use-middleware : Use restObjectFetch middleware}
                            {--m|create-model : Create model file (using existing command)}
                            {--g|create-migration : Create migration file (using existing command)}
                            {--t|create-tests : Create simple tests for CRUD routes/actions}
                            ';
    
    protected $description = 'Generate CRUD for model';
    
    private $infoMessages = [
        StubType::CONTROLLER => 'Creating controller',
        StubType::MODEL      => 'Creating model',
        StubType::MIGRATION  => 'Creating migration',
        StubType::ROUTES     => 'Adding routes',
        StubType::TESTS      => 'Creating tests',
    ];
    
    private $modelName;
    
    public function handle() {
        $this->modelName = studly_case(str_singular($this->argument('model')));
        $this->alert("CRUD generation for model '{$this->modelName}'");
        
        if($this->option('use-middleware'))
            $this->info(' -> Using RestObjectFetch middleware!');
        
        $this->createCrudElement(StubType::CONTROLLER);
        
        if($this->option('create-routes'))
            $this->createCrudElement(StubType::ROUTES);
        
        if($this->option('create-model'))
            $this->createCrudElement(StubType::MODEL);
        
        if($this->option('create-migration'))
            $this->createCrudElement(StubType::MIGRATION);
        
        if($this->option('create-tests'))
            $this->createCrudElement(StubType::TESTS);
    }
    
    private function createCrudElement(string $stubType) {
        $this->info(' -> ' . $this->infoMessages[$stubType] . ' . . .');
        if($this->saveCrudElement($stubType) === null)
            $this->error('Failed to save file!');
    }
    
    private function saveCrudElement(string $stubType) {
        $stubFilePath = config('lumen-crud.stubs')[$stubType];
        
        if($this->option('use-middleware') && array_key_exists($stubType . '_rof', config('lumen-crud.stubs')))
            $stubFilePath = config('lumen-crud.stubs')[$stubType . '_rof'];
        
        $crudContent = file_get_contents($stubFilePath);
        $crudContent = $this->getContentReplaced($crudContent);
        $targetPath = $this->getTargetPath($stubType);
        $this->comment("\t" . $targetPath);
        
        if(!file_exists(dirname($targetPath)))
            if(!mkdir(dirname($targetPath), 0755, true) && !is_dir(dirname($targetPath)))
                throw new \RuntimeException(sprintf('Directory "%s" was not created', dirname($targetPath)));
        
        return file_put_contents(
            $targetPath,
            $crudContent,
            config('lumen-crud.write_flags')[$stubType] ?? 0
        );
    }
    
    private function getContentReplaced(string $content) : string {
        foreach($this->getReplacementArray() as $fieldName => $value)
            $content = str_replace('{{' . $fieldName . '}}', $value, $content);
        
        return $content;
    }
    
    private function getReplacementArray() : array {
        return [
            'modelName'         => $this->modelName,
            'modelNamePlural'   => str_plural($this->modelName),
            'model_name'        => snake_case($this->modelName),
            'model_name_plural' => snake_case(str_plural($this->modelName)),
            'modelsNamespace'   => config('lumen-crud.namespaces.models'),
            'modelsFolder'      => preg_replace(['/^(App)($|\\\\)/', '/\\\\/'], [app()->path() . '${2}', '/'], config('lumen-crud.namespaces.models')),
        ];
    }
    
    private function getTargetPath(string $stubType) : string {
        $configPath = $this->getContentReplaced(config('lumen-crud.targets')[$stubType]);
        $configPath = dirname($configPath) . '/' . basename($configPath);
        $configPath = preg_replace('/\\' . DIRECTORY_SEPARATOR . '+/', DIRECTORY_SEPARATOR, $configPath);
        
        return file_exists($configPath) ? realpath($configPath) : $configPath;
    }
}
