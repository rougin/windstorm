<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;
use Rougin\Windstorm\Fixture\Mutators\UpdateUser;
use Rougin\Windstorm\Fixture\UserRepository;

/**
 * Result Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\Fixture\UserRepository
     */
    protected $user;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $paths = array($root = __DIR__ . '/..');

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $builder = new QueryBuilder($manager->getConnection());

        $result = new Result($manager->getConnection());

        $query = new Query($builder);

        $this->user = new UserRepository($query, $result);
    }

    /**
     * Tests ResultInterface::query.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $expected = require __DIR__ . '/../Fixture/UserItems.php';

        $result = $this->user->set(new ReturnUsers);

        $this->assertEquals($expected, $result->items());
    }

    /**
     * Tests ResultInterface::result with update.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testExecuteMethodWithUpdate()
    {
        $data = array('id' => 1, 'name' => 'Windstorm');

        $mutator = new UpdateUser(1, (array) $data);

        $result = $this->user->set($mutator);

        $this->assertEquals(1, $result->affected());
    }
}
