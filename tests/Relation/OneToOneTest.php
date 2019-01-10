<?php

namespace Rougin\Windstorm\Relation;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Doctrine\Result;
use Rougin\Windstorm\Fixture\Mappings\PostMapping;
use Rougin\Windstorm\Fixture\Mutators\ReturnPosts;
use Rougin\Windstorm\QueryRepository;

/**
 * One-To-One Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OneToOneTest extends \PHPUnit_Framework_TestCase
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
        $expected = require __DIR__ . '/../Fixture/PostItems.php';

        $query = clone $this->query;

        $query->mutate(new ReturnPosts);
        $query->mapping(new PostMapping);

        $result = $query->items();

        $this->assertEquals($expected, $result);
    }
}
