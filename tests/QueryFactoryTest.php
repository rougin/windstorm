<?php

namespace Rougin\Windstorm;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Query;
use Rougin\Windstorm\Fixture\UserQuery;

/**
 * Query Factory Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\QueryFactory
     */
    protected $factory;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $builder = new Builder(new MySqlPlatform);

        $query = new Query($builder);

        $this->factory = new UserQuery($query);
    }

    /**
     * Tests QueryFactory::create.
     *
     * @return void
     */
    public function testCreateMethod()
    {
        $expected = 'INSERT INTO users (name, age) VALUES (?, ?)';

        $data = array('name' => 'Windstorm', 'age' => 1);

        $result = $this->factory->create((array) $data)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryFactory::delete.
     *
     * @return void
     */
    public function testDeleteMethod()
    {
        $expected = 'DELETE FROM users u WHERE u.id = :u_id';

        $result = (string) $this->factory->delete(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryFactory::find.
     *
     * @return void
     */
    public function testFindMethod()
    {
        $expected = 'SELECT u.* FROM users u';

        $expected .= ' WHERE u.id = :u_id LIMIT 1';

        $result = $this->factory->find(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryFactory::paginate.
     *
     * @return void
     */
    public function testPaginateMethod()
    {
        $expected = 'SELECT u.* FROM users u';

        $expected .= ' LIMIT 10 OFFSET 10';

        $result = $this->factory->paginate(10, 10)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryFactory::update.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $data = array('name' => 'Windstorm');

        $expected = 'UPDATE users u SET u.name = :u_name';

        $expected .= ' WHERE u.id = :u_id';

        $result = $this->factory->update(1, $data)->sql();

        $this->assertEquals($expected, $result);
    }
}
