# Windstorm

[![Latest Version on Packagist][ico-version]][link-packagist]
[![Software License][ico-license]][link-license]
[![Build Status][ico-travis]][link-travis]
[![Coverage Status][ico-scrutinizer]][link-scrutinizer]
[![Quality Score][ico-code-quality]][link-code-quality]
[![Total Downloads][ico-downloads]][link-downloads]

Windstorm is an expressive SQL query builder based on top of Doctrine's [Database Abstraction Layer (DBAL)](https://www.doctrine-project.org/projects/dbal.html). It has the same functionalities from DBAL's query builder but the difference is it does not requires a `Doctrine\DBAL\Connection` instance.

## Install

Install Windstorm via [Composer](https://getcomposer.org):

``` bash
$ composer require rougin/windstorm
```

## Usage

### Configuration

Since the query builder does not require `Doctrine\DBAL\Connection` by default, it needs to have a specified platform defined:

``` php
use Doctrine\DBAL\Platforms\MySqlPlatform;
use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Query;

// https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/reference/platforms.html
$platform = new MySqlPlatform;

$builder = new Builder($platform);

$query = new Query($builder);
```

If the platform needs to came from a database connection, just specify the `Doctrine\DBAL\Connection` instance:

``` php
use Doctrine\DBAL\DriverManager;
use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Query;

// https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/reference/configuration.html#configuration
$connection = DriverManager::getConnection($database);

$query = new Query(new Builder($connection));
```

### Query Builder

``` php
$query = $query
->select(array('u.id', 'u.name'))
->from('users')
->where('name')->like('%winds%')
->orderBy('created_at')->descending();
```

#### Compiled raw SQL

``` php
echo $query->sql();
```

``` bash
SELECT u.id, u.name FROM users u WHERE name LIKE ? ORDER BY created_at DESC
```

#### Parameter bindings

``` php
print_r($query->bindings());
```

``` bash
Array
(
    [0] => %winds%
)
```

## Credits

- [Rougin Gutib][link-author]
- [All contributors][link-contributors]

## License

The MIT License (MIT). Please see [LICENSE][link-license] for more information.

[ico-version]: https://img.shields.io/packagist/v/rougin/windstorm.svg?style=flat-square
[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-travis]: https://img.shields.io/travis/rougin/windstorm/master.svg?style=flat-square
[ico-scrutinizer]: https://img.shields.io/scrutinizer/coverage/g/rougin/windstorm.svg?style=flat-square
[ico-code-quality]: https://img.shields.io/scrutinizer/g/rougin/windstorm.svg?style=flat-square
[ico-downloads]: https://img.shields.io/packagist/dt/rougin/windstorm.svg?style=flat-square

[link-author]: https://rougin.github.io
[link-changelog]: https://github.com/rougin/windstorm/blob/master/CHANGELOG.md
[link-code-quality]: https://scrutinizer-ci.com/g/rougin/windstorm
[link-contributors]: https://github.com/rougin/windstorm/contributors
[link-downloads]: https://packagist.org/packages/rougin/windstorm
[link-license]: https://github.com/rougin/windstorm/blob/master/LICENSE.md
[link-packagist]: https://packagist.org/packages/rougin/windstorm
[link-scrutinizer]: https://scrutinizer-ci.com/g/rougin/windstorm/code-structure
[link-travis]: https://travis-ci.org/rougin/windstorm