<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\ResultSetMappingBuilder;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Fixture\UserEntity;
use Rougin\Windstorm\Fixture\UserQuery;

/**
 * Result Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ResultTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\QueryFactory
     */
    protected $factory;

    /**
     * @var \Rougin\Windstorm\ResultInterface
     */
    protected $result;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        list($paths, $root) = array(array(__DIR__ . '/..'), __DIR__ . '/..');

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $this->result = new Result($manager);

        $builder = new QueryBuilder($manager->getConnection());

        $this->factory = new UserQuery(new Query($builder));
    }

    /**
     * Tests ResultInterface::execute.
     *
     * @return void
     */
    public function testExecuteMethod()
    {
        $expected = require __DIR__ . '/../Fixture/UserItems.php';

        $query = $this->factory->paginate();

        $result = $query->execute($this->result);

        $result = $result->fetchAll(\PDO::FETCH_ASSOC);

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

        $manager = $this->result->manager();

        $mapping = new ResultSetMappingBuilder($manager);

        $mapping->addRootEntityFromClassMetadata($entity, 'users');

        $this->result->mapping($mapping);

        $expected = array(new UserEntity(2, 'SQL Builder'));

        $query = $this->factory->paginate(10, 0);

        $query = $query->where('name')->like('%SQL%');

        $result = $query->execute($this->result);

        $this->assertEquals($expected, $result);
    }
}
