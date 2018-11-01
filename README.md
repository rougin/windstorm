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

$builder = new Builder($platform);

$query = new Query($builder);
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

// array(':u_name' => 'string');
$types = $query->types();
```

If there are is no alias defined in the second parameter of `from`, it will automatically get the first character of the specified table. With this, it is recommended to add the alias of the base table when selecting specific fields in `select`.

### Results

To return the results from a defined query, an instance must be implemented in `ResultInterface`.

``` php
// $manager instanceof Doctrine\ORM\EntityManager
// $query instanceof Rougin\Windstorm\QueryInterface

use Rougin\Windstorm\Doctrine\Result;

$query = $query->select(array('u.*'))->from('users');

$result = $query->result(new Result($manager));

var_dump($result->fetchAll(\PDO::FETCH_ASSOC));
```

``` php
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

If `doctrine/orm` is installed, the `Rougin\Windstorm\Doctrine\Result` instance can set a `Doctrine\ORM\Query\ResultSetMapping` instance to put the results into user-defined entities:

``` php
namespace Acme\Entities;

/**
 * @Entity
 * @Table(name="users")
 */
class UserEntity
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=false, unique=false)
     * @var integer
     */
    protected $id;

    /**
     * @Column(name="name", type="string", length=200, nullable=false, unique=false)
     * @var string
     */
    protected $name;

    /**
     * Initializes the entity instance.
     *
     * @param integer $id
     * @param string  $name
     */
    public function __construct($id, $name)
    {
        $this->id = $id;

        $this->name = $name;
    }

    /**
     * Returns the ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
```

``` php
// $query instanceof Rougin\Windstorm\QueryInterface
// $result instanceof Rougin\Windstorm\Doctrine\Result

$entity = 'Acme\Entities\User';

$mapping = new ResultSetMappingBuilder($result->manager());

$mapping->addRootEntityFromClassMetadata($entity, 'users');

$result->mapping($mapping);

$query = $query->select(array('u.*'))->from('users');

$query = $query->where('name')->like('%SQL%');

var_dump($query->execute($result));
```

``` php
array(1) {
  [0] =>
  class Acme\Entities\User#7086 (2) {
    protected $id =>
    int(2)
    protected $name =>
    string(11) "SQL Builder"
  }
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