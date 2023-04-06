# Laravel Query Diagnosis

[![Latest Version on Packagist](https://img.shields.io/packagist/v/samasend/laravel-query-diagnosis.svg?style=flat-square)](https://packagist.org/packages/samasend/laravel-query-diagnosis)
[![Build Status](https://img.shields.io/travis/samasend/laravel-query-diagnosis/master.svg?style=flat-square)](https://travis-ci.org/samasend/laravel-query-diagnosis)
[![Quality Score](https://img.shields.io/scrutinizer/g/samasend/laravel-query-diagnosis.svg?style=flat-square)](https://scrutinizer-ci.com/g/samasend/laravel-query-diagnosis)
[![Total Downloads](https://img.shields.io/packagist/dt/samasend/laravel-query-diagnosis.svg?style=flat-square)](https://packagist.org/packages/samasend/laravel-query-diagnosis)

This is a [Laravel](https://laravel.com) package that detects and reports unoptimized database queries by leveraging the
database's EXPLAIN feature. This valuable tool helps developers identify performance bottlenecks, optimize database
interactions, and enhance the overall efficiency of their applications. By integrating seamlessly into Laravel projects,
this package serves as a crucial resource for maintaining optimal database performance and delivering smooth, responsive
user experiences.

> This package is heavily inspired
> by [beyondcode/laravel-query-detector](https://github.com/beyondcode/laravel-query-detector).

## Installation

You can install the package via composer:

```bash
composer require samasend/laravel-query-diagnosis --dev
```

The package will automatically register itself.

### Testing

``` bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security related issues, please email security@sam.et instead of using the issue tracker.

## Credits

- [Samson Endale](https://github.com/SamAsEnd)
- [Marcel Pociot](https://github.com/mpociot)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
