<?php

namespace Rougin\Windstorm\Mutators;

use Doctrine\DBAL\Query\QueryBuilder;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Doctrine\Result;
use Rougin\Windstorm\Fixture\UserRepository;

/**
 * Test Case
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class TestCase extends \PHPUnit_Framework_TestCase
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
        $paths = array($root = (string) __DIR__ . '/..');

        $config = Setup::createAnnotationMetadataConfiguration($paths, true);

        $database = array('path' => (string) $root . '/Fixture/Database.db');

        $database['driver'] = 'pdo_sqlite';

        $manager = EntityManager::create($database, $config);

        $builder = new QueryBuilder($manager->getConnection());

        $result = new Result($manager->getConnection());

        $query = new Query($builder);

        $this->user = new UserRepository($query, $result);
    }
}
