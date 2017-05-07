# LaravelBase [![Latest Stable Version](https://poser.pugx.org/midnite81/laravel-base/version)](https://packagist.org/packages/midnite81/laravel-base) [![Total Downloads](https://poser.pugx.org/midnite81/laravel-base/downloads)](https://packagist.org/packages/midnite81/laravel-base) [![Latest Unstable Version](https://poser.pugx.org/midnite81/laravel-base/v/unstable)](https://packagist.org/packages/midnite81/laravel-base) [![License](https://poser.pugx.org/midnite81/laravel-base/license.svg)](https://packagist.org/packages/midnite81/laravel-base)
Some base functionality for Laravel

Work in progress - proper documentation to follow.

# Installation

This package requires PHP 5.6+, and includes a Laravel 5 Service Provider and Facade.

To install through composer include the package in your `composer.json`.

    "midnite81/laravel-base": "1.0.*"

Run `composer install` or `composer update` to download the dependencies or you can run `composer require midnite81/laravel-base`.

## Refresh Autoloader

At this point some users may need to run the command `composer dump-autoload`. Alternatively, you can run `php artisan optimize`
which should include the dump-autoload command.

Documentation 

[Searchable Trait](https://github.com/midnite81/laravel-base/blob/master/docs/searchable.md)
[Helpers](https://github.com/midnite81/laravel-base/blob/master/docs/helpers.md)