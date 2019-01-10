<?php

namespace Rougin\Windstorm\Relation;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Doctrine\Result;
use Rougin\Windstorm\Fixture\Mappings\UserPostMapping;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsersWithPosts;
use Rougin\Windstorm\QueryRepository;

/**
 * One-To-Many Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OneToManyTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\Fixture\UserRepository
     */
    protected $user;

    /**
     * @var \Rougin\Windstorm\QueryRepository
     */
    protected $query;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $paths = array($root = (string) __DIR__ . '/../');

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $builder = new QueryBuilder($manager->getConnection());

        $result = new Result($manager->getConnection());

        $query = new Query($builder);

        $this->query = new QueryRepository($query, $result);
    }

    /**
     * Tests OneToOne::make.
     *
     * @return void
     */
    public function testMakeMethod()
    {
        $expected = require __DIR__ . '/../Fixture/UserItemsWithPosts.php';

        $query = clone $this->query;

        $query->set(new ReturnUsersWithPosts);
        $query->map(new UserPostMapping);

        $result = $query->items();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests OneToOne::make with single result.
     *
     * @return void
     */
    public function testMakeMethodWithSingleResult()
    {
        $items = require __DIR__ . '/../Fixture/UserItemsWithPosts.php';

        $expected = current($items);

        $query = clone $this->query;

        $query->set(new ReturnUsersWithPosts);
        $query->map(new UserPostMapping);

        $result = $query->first();

        $this->assertEquals($expected, $result);
    }
}
