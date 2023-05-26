# Very short description of the package

[![Latest Version on Packagist](https://img.shields.io/packagist/v/quanph/simple-rake.svg?style=flat-square)](https://packagist.org/packages/quanph/simple-rake)
[![Total Downloads](https://img.shields.io/packagist/dt/quanph/simple-rake.svg?style=flat-square)](https://packagist.org/packages/quanph/simple-rake)
![GitHub Actions](https://github.com/quanph/simple-rake/actions/workflows/main.yml/badge.svg)

This is where your description should go. Try and limit it to a paragraph or two, and maybe throw in a mention of what PSRs you support to avoid any confusion with users and contributors.

## Installation

You can install the package via composer:

```bash
composer require quanph/simple-rake
```

## Usage

```php
use Quanph\SimpleRake\SimpleRake;

$text = 'needle text';
$sp = new SimpleRake($text, 'vi');
$results = $sp->extractKeywords();
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email <code.tieumomo@gmail.com> instead of using the issue tracker.

## Credits

- [Quan](https://github.com/code-tieumomo)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Laravel Package Boilerplate

This package was generated using the [Laravel Package Boilerplate](https://laravelpackageboilerplate.com).
