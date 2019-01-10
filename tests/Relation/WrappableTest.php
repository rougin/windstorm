<?php

namespace Rougin\Windstorm\Relation;

use Doctrine\DBAL\Platforms\MySqlPlatform;
use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Query;

/**
 * Wrappable Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class WrappableTest extends \PHPUnit_Framework_TestCase
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
        $builder = new Builder(new MySqlPlatform);

        $this->query = new Query($builder);
    }

    /**
     * Tests QueryInterface::select.
     *
     * @return void
     */
    public function testSelectMethod()
    {
        $query = new Wrappable($this->query);

        $expected = 'SELECT * FROM users';

        $query = $query->select(array('*'));

        $result = $query->from('users')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::from.
     *
     * @return void
     */
    public function testFromMethod()
    {
        $expected = 'SELECT * FROM users';

        $query = $this->query->select(array('*'));

        $query = new Wrappable($query);

        $result = $query->from('users')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::innerJoin.
     *
     * @return void
     */
    public function testInnerJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p INNER JOIN users u ON p.user_id = u.id';

        $query = $this->query->select(array('p.*'))->from('posts', 'p');

        $query = new Wrappable($query);

        $result = $query->innerJoin('users', 'user_id', 'id')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::leftJoin.
     *
     * @return void
     */
    public function testLeftJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p LEFT JOIN users u ON p.user_id = u.id';

        $query = $this->query->select(array('p.*'))->from('posts', 'p');

        $query = new Wrappable($query);

        $result = $query->leftJoin('users', 'user_id', 'id')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::rightJoin.
     *
     * @return void
     */
    public function testRightJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p RIGHT JOIN users u ON p.user_id = u.id';

        $query = $this->query->select(array('p.*'))->from('posts', 'p');

        $query = new Wrappable($query);

        $result = $query->rightJoin('users', 'user_id', 'id')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::insertInto.
     *
     * @return void
     */
    public function testInsertIntoMethod()
    {
        $expected = 'INSERT INTO users (name) VALUES (?)';

        $data = array('name' => 'Doctrine');

        $query = new Wrappable($this->query);

        $query = $query->insertInto('users');

        $result = $query->values($data)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::update.
     *
     * @return void
     */
    public function testUpdateMethod()
    {
        $expected = 'UPDATE users SET name = :name WHERE id = :id';

        $query = new Wrappable($this->query);

        $query = $query->update('users')->set('name', 'Windstorm');

        $result = (string) $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::deleteFrom.
     *
     * @return void
     */
    public function testDeleteFromMethod()
    {
        $expected = 'DELETE FROM users WHERE id = :id';

        $query = new Wrappable($this->query);

        $query = $query->deleteFrom('users');

        $result = $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::where.
     *
     * @return void
     */
    public function testWhereMethod()
    {
        $expected = 'SELECT * FROM users WHERE name = :name';

        $query = $this->query->select(array('*'))->from('users');

        $query = new Wrappable($query);

        $result = $query->where('name')->equals('Doctrine')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::andWhere.
     *
     * @return void
     */
    public function testAndWhereMethod()
    {
        $expected = 'SELECT * FROM users WHERE (name = :name) AND (active = 1)';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->where('name')->equals('Doctrine');

        $query = new Wrappable($query);

        $result = $query->andWhere('active')->isTrue()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::orWhere.
     *
     * @return void
     */
    public function testOrWhereMethod()
    {
        $expected = 'SELECT * FROM users WHERE (name = :name) OR (active = 1)';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->where('name')->equals('Doctrine');

        $query = new Wrappable($query);

        $result = $query->orWhere('active')->isTrue()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::groupBy.
     *
     * @return void
     */
    public function testGroupByMethod()
    {
        $expected = 'SELECT * FROM users GROUP BY active';

        $query = $this->query->select(array('*'))->from('users');

        $query = new Wrappable($query);

        $result = $query->groupBy(array('active'))->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::having.
     *
     * @return void
     */
    public function testHavingMethod()
    {
        $expected = 'SELECT * FROM users HAVING name = :name';

        $query = $this->query->select(array('*'))->from('users');

        $query = new Wrappable($query);

        $result = $query->having('name')->equals('Doctrine')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::andHaving.
     *
     * @return void
     */
    public function testAndHavingMethod()
    {
        $expected = 'SELECT * FROM users HAVING (name = :name) AND (active = 1)';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->having('name')->equals('Doctrine');

        $query = new Wrappable($query);

        $result = $query->andHaving('active')->isTrue()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::orHaving.
     *
     * @return void
     */
    public function testOrHavingMethod()
    {
        $expected = 'SELECT * FROM users HAVING (name = :name) OR (active = 1)';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->having('name')->equals('Doctrine');

        $query = new Wrappable($query);

        $result = $query->orHaving('active')->isTrue()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::orderBy.
     *
     * @return void
     */
    public function testOrderByMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name ASC';

        $query = $this->query->select(array('*'))->from('users');

        $query = new Wrappable($query);

        $result = $query->orderBy('name')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::andOrderBy.
     *
     * @return void
     */
    public function testAndOrderByMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name ASC, age DESC';

        $query = $this->query->select(array('*'))->from('users');

        $builder = $query->orderBy('name')->instance();

        $query = new Wrappable(new Query($builder));

        $result = $query->andOrderBy('age')->descending()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::limit.
     *
     * @return void
     */
    public function testLimitMethod()
    {
        $expected = 'SELECT * FROM users LIMIT 10 OFFSET 20';

        $query = $this->query->select(array('*'));

        $query = $query->from('users');

        $query = new Wrappable($query);

        $result = $query->limit(10, 20)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::sql.
     *
     * @return void
     */
    public function testSqlMethod()
    {
        $expected = 'DELETE FROM users WHERE id = :id';

        $query = $this->query->deleteFrom('users');

        $query = $query->where('id')->equals(1);

        $query = new Wrappable($query);

        $result = (string) $query->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::bindings.
     *
     * @return void
     */
    public function testBindingsMethod()
    {
        $expected = array(':id' => (integer) 1);

        $query = $this->query->deleteFrom('users');

        $query = $query->where('id')->equals(1);

        $query = new Wrappable($query);

        $result = $query->bindings();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::instance.
     *
     * @return void
     */
    public function testInstanceMethod()
    {
        $query = new Wrappable($this->query);

        $expected = 'Doctrine\DBAL\Query\QueryBuilder';

        $result = $query->instance();

        $this->assertInstanceOf($expected, $result);
    }

    /**
     * Tests Query::__clone.
     *
     * @return void
     */
    public function testCloneMagicMethod()
    {
        $expected = $this->query;

        $query = new Wrappable($this->query);

        $result = clone $query;

        $result->select('p.*');

        $this->assertNotEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::table.
     *
     * @return void
     */
    public function testTableMethod()
    {
        $expected = 'users';

        $query = $this->query->deleteFrom($expected);

        $query = new Wrappable($query);

        $result = $query->table();

        $this->assertEquals($expected, $result);
    }
}
