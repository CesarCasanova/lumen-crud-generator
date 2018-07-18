<?php

namespace WRonX\LumenCrudGenerator\Commands;

use Illuminate\Console\Command;
use WRonX\LumenCrudGenerator\Enums\StubType;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud
                            {model : Model class name}
                            {--r|create-routes : Add CRUD routes to routes file}
                            ';
    
    protected $description = 'Generate CRUD for model';
    
    private $infoMessages = [
        StubType::CONTROLLER => 'Creating controller',
        StubType::ROUTES     => 'Adding routes',
    ];
    
    private $modelName;
    
    public function handle() {
        $this->modelName = studly_case(str_singular($this->argument('model')));
        $this->alert("CRUD generation for model '{$this->modelName}'");
    
        $this->createCrudElement(StubType::CONTROLLER);
    
        if($this->option('create-routes'))
            $this->createCrudElement(StubType::ROUTES);
    }
    
    private function createCrudElement(string $stubType) {
        $this->info($this->infoMessages[$stubType] . ' . . .');
        if($this->saveCrudElement($stubType) === null)
            $this->error('Failed to save file!');
    }
    
    private function saveCrudElement(string $stubType) {
        $crudContent = file_get_contents(config('lumen-crud.stubs')[$stubType]);
        $crudContent = $this->getContentReplaced($crudContent);
        $targetPath = $this->getTargetPath($stubType);
        $this->comment("\t" . $targetPath);
        
        return file_put_contents(
            $targetPath,
            $crudContent,
            config('lumen-crud.write_flags')[$stubType]
        );
    }
    
    private function getTargetPath(string $stubType) {
        $configPath = $this->getContentReplaced(config('lumen-crud.targets')[$stubType]);
        
        return dirname($configPath) . '/' . basename($configPath);
    }
    
    private function getContentReplaced(string $content) : string {
        foreach($this->getReplacementArray() as $fieldName => $value)
            $content = str_replace('{{' . $fieldName . '}}', $value, $content);
        
        return $content;
    }
    
    private function getReplacementArray() {
        return [
            'modelName'         => $this->modelName,
            'modelNamePlural'   => str_plural($this->modelName),
            'model_name'        => snake_case($this->modelName),
            'model_name_plural' => snake_case(str_plural($this->modelName)),
        ];
    }
}
