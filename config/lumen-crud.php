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
        'migration'      => __DIR__ . '/../src/Resources/Stubs/Migration.stub',
    ],
    'targets'     => [
        'controller' => app()->path() . '/Http/Controllers/{{modelName}}Controller.php',
        'routes'     => app()->path() . '/../routes/web.php',
        'tests'      => app()->path() . '/../tests/CRUD/{{modelNamePlural}}CrudTest.php',
        'migration'  => app()->path() . '/../database/migrations/' . date("Y_m_d_His") . '_create_{{model_name_plural}}_table.php',
        'model'      => '{{modelsFolder}}/{{modelName}}.php',
    ],
    'write_flags' => [
        'routes' => FILE_APPEND,
    ],
];