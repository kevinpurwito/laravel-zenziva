# About Laravel Zenziva

[![Tests](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/run-tests.yml/badge.svg?branch=main)](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/run-tests.yml)
[![Code Style](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/php-cs-fixer.yml/badge.svg?branch=main)](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/php-cs-fixer.yml)
[![Psalm](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/psalm.yml/badge.svg?branch=main)](https://github.com/kevinpurwito/laravel-zenziva/actions/workflows/psalm.yml)
[![Latest Version on Packagist](https://img.shields.io/packagist/v/kevinpurwito/laravel-zenziva.svg?style=flat-square)](https://packagist.org/packages/kevinpurwito/laravel-zenziva)
[![Total Downloads](https://img.shields.io/packagist/dt/kevinpurwito/laravel-zenziva.svg?style=flat-square)](https://packagist.org/packages/kevinpurwito/laravel-zenziva)

Laravel Zenziva is a package that integrates [Zenziva](https://www.zenziva.id/) for Laravel.

## Installation

You can install the package via composer:

```bash
composer require kevinpurwito/laravel-zenziva
```

## Configuration

The `vendor:publish` command will publish a file named `kp_zenziva.php` within your laravel project config
folder `config/kp_zenziva.php`. Edit this file with your desired table name for the table, defaults to `countries`.

Published Config File Contents

```php
[
    'type' => strtolower(env('KP_ZENZIVA_TYPE', 'console')), // gsm or console

    'userkey' => env('KP_ZENZIVA_USERKEY'),
    
    'passkey' => env('KP_ZENZIVA_PASSKEY'),
];
```

Alternatively you can ignore the above publish command and add this following variables to your `.env` file.

```text
KP_ZENZIVA_TYPE=console
KP_ZENZIVA_USERKEY=user
KP_ZENZIVA_PASSKEY=secret
```

## Auto Discovery

If you're using Laravel 5.5+ you don't need to manually add the service provider or facade. This will be
Auto-Discovered. For all versions of Laravel below 5.5, you must manually add the ServiceProvider & Facade to the
appropriate arrays within your Laravel project `config/app.php`

### Provider

```php
[
    Kevinpurwito\LaravelZenziva\ZenzivaServiceProvider::class,
];
```

### Alias / Facade

```php
[
    'Zenziva' => Kevinpurwito\LaravelZenziva\Zenziva::class,
];
```

## Usage

```php
use Kevinpurwito\LaravelZenziva\ZenzivaFacade as Zenziva;

// returns the balance/credit that you have
Zenziva::getBalance();

// returns the balance/credit that you have, including the expiry date of the balance
Zenziva::balance();

// send SMS
Zenziva::sendSms('+62xxx', 'message');

// send Whatsapp message
Zenziva::sendWa('+62xxx', 'message');

// send Whatsapp file from URL, including a caption/message
Zenziva::sendWaFile('+62xxx', 'message', 'https://image.com/image.png');

// GSM only feature to send SMS OTP
Zenziva::sendOtp('+62xxx', '123xxx');

// Console only feature to send voice message
Zenziva::sendWa('+62xxx', 'message');
```

> Accepted file types for `sendWaFile()` are: .doc .pdf .xls .xlsx .csv .gif .jpg .mp4 .mp3

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email [kevin.purwito@gmail.com](mailto:kevin.purwito@gmail.com)
instead of using the issue tracker.

## Credits

- [Kevin Purwito](https://github.com/kevinpurwito)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [PHP Package Boilerplate](https://laravelpackageboilerplate.com)
by [Beyond Code](http://beyondco.de/)
with some modifications inspired from [PHP Package Skeleton](https://github.com/spatie/package-skeleton-php)
by [spatie](https://spatie.be/).
