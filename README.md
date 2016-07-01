Laravel Elixir Twig Extension
=============================

[![Build Status](https://img.shields.io/travis/brieucthomas/elixir-twig-extension/master.svg?style=flat-square)](https://travis-ci.org/brieucthomas/elixir-twig-extension)

The Laravel Elixir `version` task appends a unique hash to filename, 
allowing for cache-busting.
 
``` js
elixir(function(mix) {
    mix.version("css/all.css");
});
```

For example, the generated file name will look something like: 
`all-16d570a7.css`.

In Laravel, you can use in your views the `elixir()` function to load 
the appropriately hashed asset:

``` html
<link rel="stylesheet" href="{{ elixir("css/all.css") }}">
```

This twig extension is an adaptation of this `elixir()` function. 

## Requirements

You need PHP >= 5.3.0 to use the library, but the latest stable version 
of PHP is recommended.

## Install 

Install using Composer:

``` bash
composer require brieucthomas/elixir-twig-extension
```

This will edit (or create) your composer.json file and automatically 
choose the most recent version.

## Documentation

### Register the extension

``` php
use BrieucThomas\Twig\Extension\ElixirExtension;

$elixir = new ElixirExtension(
    $publicDir,     // the absolute public directory 
    $buildDir,      // the elixir versionn build directory (default value is 'build')
    $manifestName   // the manifest filename (default value is 'rev-manifest.json')
);
$twig->addExtension($elixir);
```

### Register the extension as a Symfony Service

``` yml
# app/config/services.yml
services:
    app.twig_elixir_extension:
        class: BrieucThomas\Twig\Extension\ElixirExtension
        arguments: ["%kernel.root_dir%/../web/"]
        public: false
        tags:
            - { name: twig.extension }
```

### Using the Extension

``` twig
<link href="{{ elixir('css/all.css') }}" rel="stylesheet" />
```

You can surround with the `asset` twig extension to make your 
application more portable:

``` twig
<link href="{{ asset(elixir('css/all.css')) }}" rel="stylesheet" />
```