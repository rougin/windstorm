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

If the platform needs to came from a database connection, use the `Doctrine\DBAL\Query\QueryBuilder` instance:

``` php
// $connection instanceof \Doctrine\DBAL\Connection

use Rougin\Windstorm\Doctrine\Query;

$query = new Query($connection->createQueryBuilder());
```

### Query Builder

``` php
// SELECT u.id, u.name FROM users u WHERE u.name LIKE :u_name ORDER BY u.created_at DESC

$query = $query
->select(array('u.id', 'u.name'))
->from('users')
->where('name')->like('%winds%')
->orderBy('created_at')->descending();
```

If there are is no alias defined in the second parameter of `from`, it will automatically get the first character of the specified table. So it is recommended to add the alias of the base table when selecting specific fields in `select`.

### Results

To return the results from a defined query, an instance must be implement in `ResultInterface`.

``` php
// $manager instanceof Doctrine\ORM\EntityManager
// $query instanceof Rougin\Windstorm\QueryInterface

use Rougin\Windstorm\Doctrine\Result;

$query = $query->select(['u.*'])->from('users');

$result = $query->result(new Result($manager));

$items = $result->fetchAll(\PDO::FETCH_ASSOC);
```

``` json
[
    {
        "id": "1",
        "name": "Windstorm",
        "created_at": "2018-10-15 23:06:28",
        "updated_at": null
    }
    {
        "id": "2",
        "name": "SQL Builder",
        "created_at": "2018-10-15 23:09:47",
        "updated_at": null,
    }
    {
        "id": "3",
        "name": "Rougin Gutib",
        "created_at": "2018-10-15 23:14:45",
        "updated_at": null,
    }
]
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