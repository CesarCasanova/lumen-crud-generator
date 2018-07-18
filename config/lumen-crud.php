<?php
return [
    'stubs'       => [
        'controller' => __DIR__ . '/../src/Resources/Stubs/Controller.stub',
        'routes'     => __DIR__ . '/../src/Resources/Stubs/Routes.stub',
    ],
    'targets'     => [
        'controller' => app()->path() . '/Http/Controllers/{{modelNamePlural}}Controller.php',
        'routes'     => app()->path() . '/../routes/web.php',
    ],
    'write_flags' => [
        'controller' => 0,
        'routes'     => FILE_APPEND,
    ],
];