# [Unofficial] Slim Framework 3.x Plates View

[![LICENSE](https://img.shields.io/packagist/l/projek-xyz/slim-plates.svg?style=flat-square)](LICENSE.md)
[![VERSION](https://img.shields.io/github/release/projek-xyz/slim-plates.svg?style=flat-square)](https://github.com/projek-xyz/slim-plates/releases)
[![Build Status](https://img.shields.io/travis/projek-xyz/slim-plates/master.svg?branch=master&style=flat-square)](https://travis-ci.org/projek-xyz/slim-plates)
[![Coveralls](https://img.shields.io/coveralls/projek-xyz/slim-plates/master.svg?style=flat-square)](https://coveralls.io/github/projek-xyz/slim-plates)
[![Code Quality](https://img.shields.io/sensiolabs/i/0b18f66c-8041-47c3-8004-6eef2b940d30.svg?style=flat-square)](https://insight.sensiolabs.com/projects/0b18f66c-8041-47c3-8004-6eef2b940d30)

This is a Slim Framework 3.x component helper built on top of the Plates templating system. You can use this component to create and render templates in your Slim Framework application.

## Install

Via [Composer](https://getcomposer.org/)

```bash
$ composer require projek-xyz/slim-plates --prefer-dist
```

Requires Slim Framework 3 and PHP 5.5.0 or newer.

## Usage

```php
// Create Slim app
$app = new \Slim\App();

// Fetch DI Container
$container = $app->getContainer();

// Register Plates View helper:
// Option 1, using PlatesProvider
$container->register(new \Projek\Slim\PlatesProvider);

// Option 2, using Closure
$container['view'] = function ($c) {
    $settings = [
        // Path to view directory
        'directory'     => 'path/to/views',
        // Path to asset directory
        'assetPath'     => 'path/to/static/assets',
        // Template extension (default: 'php')
        'fileExtension' => 'tpl',
    ];
    $view = new \Projek\Slim\Plates($settings);

    // Instantiate and add Slim specific extension
    $view->loadExtension(
        new Projek\Slim\PlatesExtension($c['router'], $c['request']->getUri())
    );

    return $view;
};

// Define named route
$app->get('/hello/{name}', function ($request, $response, $args) {
    return $this->view->render($response, 'profile', [
        'name' => $args['name']
    ]);
})->setName('profile');

// Run app
$app->run();
```

**NOTE**: if you are using _option 1_ please make sure you already have `$container['settings']['view']` in your configuration file.

## Custom functions

This component exposes some Slim functions to your Plates templates.

### `pathFor()`

You can use this function to generate complete URLs to any Slim application named route. Example:

```php
<?php $this->layout('base-template') ?>

<?php $this->start('body') ?>
<h1>Hallo <?=$this->e($name)?></h1>
<small><?=$this->pathFor('profile', ['name'=> $name])?></small>
<?php $this->stop() ?>
```

### `baseUrl()`

Retrieve the base url of your Slim application. Example:

```php
<a href="<?=$this->baseUrl()?>">Some Link</a>
```

### `basePath()`

Retrieve the base url of your Slim application. Example:

```php
<link rel="stylesheet" href="<?=$this->basePath().'asset/css/main.css'?>">
```

### `uriScheme()`

Retrieve the [scheme](https://tools.ietf.org/html/rfc3986#section-3.1) component of the URI.

### `uriHost()`

Retrieve the [host](http://tools.ietf.org/html/rfc3986#section-3.2.2) component of the URI

### `uriPort()`

Retrieve the [port](https://tools.ietf.org/html/rfc3986#section-3.2.3) component of the URI.

### `uriPath()`

Retrieve the [path](https://tools.ietf.org/html/rfc3986#section-3.3) component of the URI.

### `uriQuery()`

Retrieve the [query string](https://tools.ietf.org/html/rfc3986#section-3.4) component of the URI.

## Testing

```bash
phpunit
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Fery Wardiyanto](http://feryardiant.me)
- [Slim Framework](http://www.slimframework.com)
- [Plates Template](http://platesphp.com)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
