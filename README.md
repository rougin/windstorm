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
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Query;

// $platform instanceof AbstractPlatform

$query = new Query(new Builder($platform));
```

List of supported platforms: https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/reference/platforms.html

#### Using a `Connection` instance

If the platform needs to came from a database connection, use `Connection::createQueryBuilder` instead:

``` php
use Doctrine\DBAL\Connection;
use Rougin\Windstorm\Doctrine\Query;

// $connection instanceof Connection

$query = new Query($connection->createQueryBuilder());
```

Getting a connection: https://www.doctrine-project.org/projects/doctrine-dbal/en/2.8/reference/configuration.html#configuration

### Query Builder

The query builder syntax is similar when writing SQL queries:

``` php
// $query instanceof Rougin\Windstorm\QueryInterface

$query = $query
->select(array('u.id', 'u.name'))
->from('users', 'u')
->where('name')->like('%winds%')
->orderBy('created_at')->descending();

// SELECT u.id, u.name FROM users u WHERE u.name LIKE :u_name ORDER BY u.created_at DESC
$sql = $query->sql();

// array(':u_name' => '%winds%')
$bindings = $query->bindings();
```

### Returning results

To return the results from a defined query, an instance must be implemented in `ResultInterface`.

``` php
// $connection instanceof Doctrine\DBAL\Connection
// $query instanceof Rougin\Windstorm\QueryInterface

use Rougin\Windstorm\Doctrine\Result;

$execute = new Result($connection);

$query = $query->select(array('u.*'));

$query = $query->from('users');

$result = $execute->execute($query);

var_dump((array) $result->items());
```

``` bash
array(3) {
  [0] =>
  array(4) {
    'id' =>
    string(1) "1"
    'name' =>
    string(9) "Windstorm"
    'created_at' =>
    string(19) "2018-10-15 23:06:28"
    'updated_at' =>
    NULL
  }
  [1] =>
  array(4) {
    'id' =>
    string(1) "2"
    'name' =>
    string(11) "SQL Builder"
    'created_at' =>
    string(19) "2018-10-15 23:09:47"
    'updated_at' =>
    NULL
  }
  [2] =>
  array(4) {
    'id' =>
    string(1) "3"
    'name' =>
    string(12) "Rougin Gutib"
    'created_at' =>
    string(19) "2018-10-15 23:14:45"
    'updated_at' =>
    NULL
  }
}
```

### QueryRepository and mutators

The `QueryRepository` instance is a special class that will mutate the `QueryInterface` through the use the mutators. The logic is loosely based on a [specification design pattern](https://en.wikipedia.org/wiki/Specification_pattern).

``` php
// $query instanceof Rougin\Windstorm\QueryInterface;
// $result instanceof Rougin\Windstorm\ResultInterface;

use Rougin\Windstorm\Mutators\ReturnEntity;
use Rougin\Windstorm\Mutators\ReturnEntities;

$query = $query->select(['*'])->from('users');

$query = new QueryRepository($query, $result);

$query = $query->mutate(new ReturnEntity(1));

var_dump($query->first());
```

``` bash
array(4) {
  'id' =>
  string(1) "1"
  'name' =>
  string(9) "Windstorm"
  'created_at' =>
  string(19) "2018-10-15 23:06:28"
  'updated_at' =>
  NULL
}
```

To map the result into a class, implement a mapper into a `MapperInterface`:

``` php
namespace Acme\Mappers;

use Acme\Models\User;

class UserMapper implements MapperInterface
{
    public function map(array $data)
    {
        return new User($data['id'], $data['name']);
    }
}
```

``` php
// $query instanceof Rougin\Windstorm\QueryRepository;

use Acme\Mappers\UserMapper;

$query->mapper(new UserMapper);

var_dump($query->first());
```

``` bash
class Acme\Models\User#11 (2) {
  protected $id =>
  string(1) "1"
  protected $name =>
  string(6) "Windstorm"
}
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