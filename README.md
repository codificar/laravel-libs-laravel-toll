# Laravel toll
A laravel lib to import tolls


## Installation

Add in composer.json:

```php
"repositories": [
    {
        "type": "vcs",
        "url": "https://libs:ofImhksJ@git.codificar.com.br/laravel-libs/laravel-toll.git"
    }
]
```

```php
require:{
        "codificar/toll": "0.1.0",
}
```

```php
"autoload": {
    "psr-4": {
        "Codificar\\Toll\\": "vendor/codificar/toll/src/"
    },
}
```

Update project dependencies:

```shell
$ composer update
```

Register the service provider in `config/app.php`:

```php
'providers' => [
  /*
   * Package Service Providers...
   */
  Codificar\Toll\TollServiceProvider::class,
],
```


Publish Js Libs and Tests:

```shell
$ php artisan vendor:publish --tag=public_vuejs_libs --force
```


Run the migrations:

```shell
$ php artisan migrate
```
