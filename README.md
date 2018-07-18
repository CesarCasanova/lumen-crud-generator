## Lumen CRUD Generator

> **IMPORTANT:** This package is a work in progress, it it not stable by any means.   
> Use responsibly! Or don't use at all and wait for v1.0.

#### The purpose of this project

It was created to make creating simple Lumen APIs easier and faster, automating repeatable tasks.

#### Is it any good?

[Yes](https://news.ycombinator.com/item?id=3067434)

(well, it will be in stable version... I hope...)

## Installation

1. Install the package with [Composer](https://getcomposer.org/):  
 
```bash
composer require --dev wronx/lumen-crud-generator
```

2. Enable it in `bootstrap/app.php`:

```php
// edit the environment condition below:
if(!in_array($app->environment(), ['testing', 'staging', 'production']))
    $app->register(WRonX\LumenCrudGenerator\Providers\LumenCrudGeneratorProvider::class);
```

3. Check if the `make:crud` command is present in the Artisan list.  


## Usage

`php artisan make:crud myModelName [-r|--create-routes]`

The command always created CRUD controller for model, the rest depends on the provided options.

## Contributing

If you want to contribute, **please wait**. Until stable version arrives I want to shape this package in my specific way. Later on, pull requests will be welcome. 

## License:

> Copyright © 2016 github.com/WRonX    
> This work is free. You can redistribute it and/or modify it under the terms of the Do What The Fuck You Want To Public License, Version 2, as published by Sam Hocevar. See http://www.wtfpl.net/ for more details
