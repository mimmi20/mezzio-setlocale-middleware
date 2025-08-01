# mezzio-setlocale-middleware

[![Latest Stable Version](https://poser.pugx.org/mimmi20/mezzio-setlocale-middleware/v/stable?format=flat-square)](https://packagist.org/packages/mimmi20/mezzio-setlocale-middleware)
[![Latest Unstable Version](https://poser.pugx.org/mimmi20/mezzio-setlocale-middleware/v/unstable?format=flat-square)](https://packagist.org/packages/mimmi20/mezzio-setlocale-middleware)
[![License](https://poser.pugx.org/mimmi20/mezzio-setlocale-middleware/license?format=flat-square)](https://packagist.org/packages/mimmi20/mezzio-setlocale-middleware)

## Code Status

[![codecov](https://codecov.io/gh/mimmi20/mezzio-setlocale-middleware/branch/master/graph/badge.svg)](https://codecov.io/gh/mimmi20/mezzio-setlocale-middleware)
[![Average time to resolve an issue](https://isitmaintained.com/badge/resolution/mimmi20/mezzio-setlocale-middleware.svg)](https://isitmaintained.com/project/mimmi20/mezzio-setlocale-middleware "Average time to resolve an issue")
[![Percentage of issues still open](https://isitmaintained.com/badge/open/mimmi20/mezzio-setlocale-middleware.svg)](https://isitmaintained.com/project/mimmi20/mezzio-setlocale-middleware "Percentage of issues still open")
[![Mutation testing badge](https://img.shields.io/endpoint?style=flat&url=https%3A%2F%2Fbadge-api.stryker-mutator.io%2Fgithub.com%2Fmimmi20%2Fmezzio-setlocale-middleware%2Fmaster)](https://dashboard.stryker-mutator.io/reports/github.com/mimmi20/mezzio-setlocale-middleware/master)

## Introduction

This component provides middleware for [Mezzio](https://github.com/mezzio/mezzio)
and [PSR-7](https://www.php-fig.org/psr/psr-7/) applications to set the locale and the language for a translator based on the `HTTP_ACCEPT_LANGUAGE` Header.

## Requirements

This library requires

- PHP 8.3+.
- a translator

## Installation

Run

```shell
composer require mimmi20/mezzio-setlocale-middleware
```

## Add the Middleware to the pipeline

```php
<?php
return [
    'middleware' => [
        // ...
        \Mimmi20\Mezzio\Middleware\SetLocaleMiddleware::class, // <-- Add this line
        // ... <-- any middleware or request handler wich uses the translator
    ],
];
```

If you need the Translator for the Routing, you have to add the Middleware in the Pipeline before the Routing.

```php
    $app->pipe(\Mimmi20\Mezzio\Middleware\SetLocaleMiddleware::class); // <-- Add this line

    // Register the routing middleware in the middleware pipeline.
    // This middleware registers the Mezzio\Router\RouteResult request attribute.
    $app->pipe(RouteMiddleware::class);
```

## License

This package is licensed using the MIT License.

Please have a look at [`LICENSE.md`](LICENSE.md).
