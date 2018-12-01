<?php

namespace Rougin\Windstorm\Eloquent;

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
        $expected = 'select * from "users"';

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
        $expected = 'select * from "posts" inner join "users" on "user_id" = "id"';

        $query = $this->query->select(array('*'))->from('posts');

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
        $expected = 'select * from "posts" left join "users" on "user_id" = "id"';

        $query = $this->query->select(array('*'))->from('posts');

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
        $expected = 'select * from "posts" right join "users" on "user_id" = "id"';

        $query = $this->query->select(array('*'))->from('posts');

        $result = $query->rightJoin('users', 'user_id', 'id')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::deleteFrom.
     *
     * @return void
     */
    // public function testDeleteFromMethod()
    // {
    //     $expected = 'DELETE FROM users WHERE id = :u_id';

    //     $query = $this->query->deleteFrom('users');

    //     $result = $query->where('id')->equals(1)->sql();

    //     $this->assertEquals($expected, $result);
    // }

    /**
     * Tests QueryInterface::andWhere.
     *
     * @return void
     */
    public function testAndWhereMethod()
    {
        $expected = 'select * from "users" where "name" = ? and "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->where('name')->equals('Eloquent');

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
        $expected = 'select * from "users" where "name" = ? or "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->where('name')->equals('Eloquent');

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
        $expected = 'select * from "users" group by "active"';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->groupBy('active')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::having.
     *
     * @return void
     */
    public function testHavingMethod()
    {
        $expected = 'select * from "users" having "name" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->having('name')->equals('Eloquent')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests QueryInterface::andHaving.
     *
     * @return void
     */
    public function testAndHavingMethod()
    {
        $expected = 'select * from "users" having "name" = ? and "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->having('name')->equals('Eloquent');

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
        if (! class_exists('Illuminate\Database\Concerns'))
        {
            $this->markTestSkipped('Eloquent does not support orHaving in this version.');
        }

        $expected = 'select * from "users" having "name" = ? or "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $query = $query->having('name')->equals('Eloquent');

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
        $expected = 'select * from "users" order by "name" asc, "age" desc';

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
        $expected = 'select * from "users" limit 10 offset 20';

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
    // public function testSqlMethod()
    // {
    //     $expected = 'DELETE FROM users WHERE id = :u_id';

    //     $query = $this->query->deleteFrom('users');

    //     $result = $query->where('id')->equals(1)->sql();

    //     $this->assertEquals($expected, $result);
    // }

    /**
     * Tests QueryInterface::bindings.
     *
     * @return void
     */
    // public function testBindingsMethod()
    // {
    //     $expected = array(':u_id' => (integer) 1);

    //     $query = $this->query->deleteFrom('users');

    //     $result = $query->where('id')->equals(1)->bindings();

    //     $this->assertEquals($expected, $result);
    // }

    /**
     * Tests QueryInterface::types.
     *
     * @return void
     */
    public function testTypesMethod()
    {
        $result = (array) $this->query->types();

        $this->assertEquals(array(), $result);
    }
}
