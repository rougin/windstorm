<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Capsule\Manager;
use Rougin\Windstorm\Fixture\UserModel;

/**
 * Test Case
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $fixture = str_replace('Eloquent', 'Fixture', __DIR__);

        $manager = new Manager;

        $connection = array('collation' => 'utf8_unicode_ci');

        $connection['driver'] = 'sqlite';

        $connection['database'] = $fixture . '/Database.db';

        $manager->addConnection($connection);

        $manager->setAsGlobal();

        $manager->bootEloquent();

        $this->query = new Query(new UserModel);
    }
}
