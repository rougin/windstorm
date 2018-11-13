<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Fixture\UserEntity;
use Rougin\Windstorm\Fixture\UserQuery;

/**
 * Execute Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ExecuteTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\Doctrine\Execute
     */
    protected $execute;

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

        $this->execute = new Execute($manager);
    }

    /**
     * Tests ResultInterface::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $query = new Query($this->builder());

        $factory = new UserQuery($query);

        $expected = require __DIR__ . '/../Fixture/UserItems.php';

        $query = $factory->paginate();

        $result = $this->execute->execute($query);

        $result = $result->items();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::execute with update.
     *
     * @depends testExecuteMethod
     *
     * @return void
     */
    public function testExecuteMethodWithUpdate()
    {
        $query = new Query($this->builder());

        $factory = new UserQuery($query);

        $data = array('name' => 'Windstorm');

        $query = $factory->update(1, $data);

        $result = $this->execute->execute($query);

        $expected = 1;

        $result = $result->affected();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests ResultInterface::execute with mapping.
     *
     * @return void
     */
    public function testExecuteMethodWithMapping()
    {
        $entity = 'Rougin\Windstorm\Fixture\UserEntity';

        $manager = $this->execute->manager();

        $mapping = new ResultSetMappingBuilder($manager);

        $mapping->addRootEntityFromClassMetadata($entity, 'users');

        $this->execute->mapping($mapping);

        $factory = new UserQuery(new Query($this->builder()));

        $expected = new UserEntity(2, 'SQL Builder');

        $query = $factory->paginate(10, 0);

        $query = $query->where('name')->like('%SQL%');

        $result = $this->execute->execute($query)->first();

        $this->assertEquals($expected, $result);
    }

    protected function builder()
    {
        $manager = $this->execute->manager();

        $connection = $manager->getConnection();

        return new QueryBuilder($connection);
    }
}
