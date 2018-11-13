<?php

namespace Rougin\Windstorm\Doctrine;

/**
 * Query Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryTest extends TestCase
{
    /**
     * Tests QueryInterface::select.
     *
     * @return void
     */
    public function testSelectMethod()
    {
        $expected = 'SELECT * FROM users';

        $query = $this->query->select(array('*'));

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

        $result = $query->rightJoin('users', 'user_id', 'id')->sql();

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

        $query = $this->query->deleteFrom('users');

        $result = $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::deleteFrom with table alias.
     *
     * @return void
     */
    public function testDeleteFromMethodWithTableAlias()
    {
        $expected = 'DELETE FROM users u WHERE u.id = :u_id';

        $query = $this->query->deleteFrom('users', 'u');

        $result = $query->where('u.id')->equals(1)->sql();

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

        $result = $query->orHaving('active')->isTrue()->sql();

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

        $result = $query->orderBy('name')->andOrderBy('age')->descending()->sql();

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

        $result = $query->where('id')->equals(1)->sql();

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

        $result = $query->where('id')->equals(1)->bindings();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::types.
     *
     * @return void
     */
    public function testTypesMethod()
    {
        $expected = array(':id' => (string) 'integer');

        $query = $this->query->deleteFrom('users');

        $result = $query->where('id')->equals(1)->types();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::instance.
     *
     * @return void
     */
    public function testInstanceMethod()
    {
        $expected = 'Doctrine\DBAL\Query\QueryBuilder';
        
        $result = $this->query->instance();

        $this->assertInstanceOf($expected, $result);
    }
}
