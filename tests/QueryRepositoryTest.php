<?php

namespace Rougin\Windstorm;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Doctrine\Result;
use Rougin\Windstorm\Fixture\Entities\User;
use Rougin\Windstorm\Fixture\Mutators\ReturnUser;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;
use Rougin\Windstorm\Fixture\Mutators\UpdateUser;
use Rougin\Windstorm\Fixture\UserRepository;

/**
 * Query Repository Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryRepositoryTest extends \PHPUnit_Framework_TestCase
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
        $paths = array($root = (string) __DIR__);

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $builder = new QueryBuilder($manager->getConnection());

        $result = new Result($manager->getConnection());

        $query = new Query($builder);

        $this->query = new QueryRepository($query, $result);

        $this->user = new UserRepository($query, $result);
    }

    /**
     * Tests QueryRepository::affected.
     *
     * @return void
     */
    public function testAffectedMethod()
    {
        $data = array('updated_at' => date('Y-m-d H:i:s'));

        $result = $this->user->set(new UpdateUser(1, $data));

        $this->assertEquals(1, $result->affected());
    }

    /**
     * Tests QueryRepository::first.
     *
     * @return void
     */
    public function testFirstMethod()
    {
        $expected = new User(1, 'Windstorm');

        $result = $this->user->set(new ReturnUser(1));

        $result = $result->first();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryRepository::first without mapping.
     *
     * @return void
     */
    public function testFirstMethodWithoutMapping()
    {
        $expected = array('id' => '1');
        $expected['name'] = 'Windstorm';
        $expected['created_at'] = '2018-10-15 23:06:28';

        $result = $this->query->set(new ReturnUser(1));

        $result = $result->first();

        unset($result['updated_at']);

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryRepository::items.
     *
     * @return void
     */
    public function testItemsMethod()
    {
        $result = $this->user->set(new ReturnUsers);

        $this->assertCount(3, $result->items());
    }

    /**
     * Tests QueryRepository::items without a mapping instance.
     *
     * @return void
     */
    public function testItemsMethodWithoutMapping()
    {
        $result = $this->query->set(new ReturnUsers);

        $this->assertCount(3, $result->items());
    }
}
