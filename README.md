# Apparel21 PHP SDK

This SDK provides simple access to the Apparel21 API. It handles most Apparel21 associated complexities including authentication, entity abstraction, errors and more.

## Contents

- [Getting started](#getting-started)
- [Prerequisites](#prerequisites)
- [Creating a client](#creating-a-client)
- [Integrating with Laravel](#integrating-with-laravel)
- [Available methods](#available-methods)
- [Contributing](#contributing)

## Getting started

Install the SDK into your project using Composer.

```bash
composer config repositories.apparel21-sdk git git@github.com:arkade-digital/apparel21-sdk.git
composer require arkade/apparel21-sdk
```

## Prerequisites

To begin sending requests to Apparel21, you will need a few pieces of information.

- __Base URL__ This is the base URL where the Apparel21 API is accessible from.
- __Username__ This is provided by Apparel21.
- __Password__ This is provided by Apparel21.

## Creating a client

> If you are using Laravel, skip to the [Integrating with Laravel](#integrating-with-laravel) section

To begin using the SDK, you will first need to create an authenticated client with the information you have obtained above.

```php
use Arkade\Apparel21;

$client = (new Apparel21\Client('http://api.example.com/RetailAPI/'))
    ->setCredentials('username', 'password');
```

If you create a client without setting credentials, all your requests will be sent without appropriate authentication headers and will most likely result in an unauthorised response.

## Integrating with Laravel

This package ships with a Laravel specific service provider which allows you to set your credentials from your configuration file and environment.

### Registering the provider

Add the following to the `providers` array in your `config/app.php` file.

```php
Arkade\Apparel21\LaravelServiceProvider::class
```

### Adding config keys

In your `config/services.php` file, add the following to the array.

```php
'apparel21' => [
    'base_url' => env('APPAREL21_BASE_URL'),
    'username' => env('APPAREL21_USERNAME'),
    'password' => env('APPAREL21_PASSWORD'),
]
```

### Adding environment keys

In your `.env` file, add the following keys.

```ini
APPAREL21_BASE_URL=
APPAREL21_USERNAME=
APPAREL21_PASSWORD=
```

### Resolving a client

To resolve a fully authenticated client, you simply pull it from the service container. This can be done in a few ways.

#### Type hinting

```php
use Arkade\Apparel21;

public function yourControllerMethod(Apparel21\Client $client) {
    // Call methods on $client
}
```

#### Using the `app()` helper

```php
use Arkade\Apparel21;

public function anyMethod() {
    $client = app(Apparel21\Client::class);
    // Call methods on $client
}
```

## Available methods

Coming soon.

## Contributing

If you wish to contribute to this library, please submit a pull request and assign to a member of Capcom for review.

All public methods should be accompanied with unit tests.

### Testing

```bash
./vendor/bin/phpunit
```