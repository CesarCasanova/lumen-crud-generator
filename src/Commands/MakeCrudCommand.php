<?php

namespace WRonX\LumenCrudGenerator\Commands;

use Illuminate\Console\Command;
use WRonX\LumenCrudGenerator\Enums\StubType;

class MakeCrudCommand extends Command
{
    protected $signature = 'make:crud
                            {model : Model class name}
                            ';
    
    protected $description = 'Generate CRUD for model';
    
    private $currentStub;
    private $currentStubContent;
    
    private $modelName;
    
    public function handle() {
        $this->modelName = studly_case(str_singular($this->argument('model')));
        $this->alert("CRUD generation for model '{$this->modelName}'");
        
        $this->createController();
    }
    
    private function createController() {
        $this->info("Creating controller . . .");
        $modelName = $this->modelName;
        $modelNamePlural = str_plural($modelName);
        $model_name_snake_case = snake_case($modelName);
        
        $this->getStub(StubType::CONTROLLER);
        $this->stubReplace(compact('modelName', 'modelNamePlural', 'model_name_snake_case'));
        $filePath = realpath(config('lumen-crud.targets')[StubType::CONTROLLER] . $modelNamePlural . 'Controller.php');
        
        file_put_contents($filePath, $this->currentStubContent);
        
        $this->comment("\t{$filePath}");
    }
    
    private function getStub($name) {
        $this->currentStub = $name;
        $this->currentStubContent = file_get_contents(config('lumen-crud.stubs')[$this->currentStub]);
    }
    
    private function stubReplace(array $fields) {
        foreach($fields as $fieldName => $value)
            $this->currentStubContent = str_replace('{{' . $fieldName . '}}', $value, $this->currentStubContent);
    }
}
