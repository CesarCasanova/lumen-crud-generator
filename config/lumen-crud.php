<?php
return [
    'namespaces'  => [
        'models' => 'App\Models',
    ],
    'stubs'       => [
        'controller'     => __DIR__ . '/../src/Resources/Stubs/Controller.stub',
        'controller_rof' => __DIR__ . '/../src/Resources/Stubs/ControllerROF.stub',
        'routes'         => __DIR__ . '/../src/Resources/Stubs/Routes.stub',
        'routes_rof'     => __DIR__ . '/../src/Resources/Stubs/RoutesROF.stub',
        'tests'          => __DIR__ . '/../src/Resources/Stubs/Tests.stub',
        'model'          => __DIR__ . '/../src/Resources/Stubs/Model.stub',
    ],
    'targets'     => [
        'controller' => app()->path() . '/Http/Controllers/{{modelNamePlural}}Controller.php',
        'routes'     => app()->path() . '/../routes/web.php',
        'tests'      => app()->path() . '/../tests/CRUD/{{modelNamePlural}}CrudTest.php',
        'model'      => '{{modelsFolder}}/{{modelName}}.php' ,
    ],
    'write_flags' => [
        'routes'     => FILE_APPEND,
    ],
];