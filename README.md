## Lumen CRUD Generator

#### The purpose of this project

It was created to make creating simple Lumen APIs easier and faster, automating repeatable tasks.

## Installation

1. Install the package with [Composer](https://getcomposer.org/):  
 
```bash
composer require --dev ccasanova/lumen-crud-generator
```

2. Enable it in `bootstrap/app.php`:

```php
// edit the environment condition below:
if(!in_array($app->environment(), ['staging', 'production']))
    $app->register(WRonX\LumenCrudGenerator\Providers\LumenCrudGeneratorProvider::class);
```

3. Check if the `make:crud` command is present in the Artisan list.  


## Usage

`php artisan make:crud myModelName [options]`

The command always created CRUD controller for model, the rest depends on the provided options:
 * `-r|--create-routes` adds CRUD routes to routes file
 * `-w|--use-middleware` uses [RestObjectFetch middleware] in controller and routes (see middleware page to learn more) 
 * `-m|--create-model` for now it calls `make:model` command from [Lumen Generator](https://packagist.org/packages/flipbox/lumen-generator), hopefully it will be changed later 
 * `-g|--create-migration` for now it calls `make:migration` command, hopefully it will be changed later
 * `-t|--create-tests` creates CRUD tests code (needs some editing inside the file!)
 
It creates separate `CRUD` subdirectory for tests, so in order to use tests, you need to update `TestCase` (or whatever your main class is) with `Tests` namespace, which involves adding `namespace Tests;` line on the top and leading slash before `Laravel` in parent class name.
 
## Contributing

If you want to contribute, **please wait**. Until stable version arrives I want to shape this package in my specific way. Later on, pull requests will be welcome. 

## License:

> Copyright © 2016 github.com/WRonX    
> This work is free. You can redistribute it and/or modify it under the terms of the Do What The Fuck You Want To Public License, Version 2, as published by Sam Hocevar. See http://www.wtfpl.net/ for more details
