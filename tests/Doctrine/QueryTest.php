<?php

namespace Rougin\Windstorm\Doctrine;

class QueryTest extends TestCase
{
    public function testSelectMethod()
    {
        $expected = 'SELECT u.* FROM users u';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $result = $query->__toString();

        $this->assertEquals($result, $expected);
    }

    public function testInnerJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p INNER JOIN users u ON p.user_id = u.id';

        $query = new Query($this->builder);

        $query = $query->select(array('p.*'))->from('posts');

        $result = $query->innerJoin('users', 'user_id', 'id');

        $this->assertEquals($expected, $result->__toString());
    }

    public function testLeftJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p LEFT JOIN users u ON p.user_id = u.id';

        $query = new Query($this->builder);

        $query = $query->select(array('p.*'))->from('posts');

        $result = $query->leftJoin('users', 'user_id', 'id');

        $this->assertEquals($expected, $result->__toString());
    }

    public function testRightJoinMethod()
    {
        $expected = 'SELECT p.* FROM posts p RIGHT JOIN users u ON p.user_id = u.id';

        $query = new Query($this->builder);

        $query = $query->select(array('p.*'))->from('posts');

        $result = $query->rightJoin('users', 'user_id', 'id');

        $this->assertEquals($expected, $result->__toString());
    }

    public function testDeleteFromMethod()
    {
        $expected = 'DELETE FROM users u WHERE u.id = :u_id';

        $query = new Query($this->builder);

        $query = $query->deleteFrom('users')->where('id')->equals(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testAndWhereMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE (u.name = :u_name) AND (u.active = 1)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->equals('Doctrine');

        $query = $query->andWhere('active')->isTrue();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testOrWhereMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE (u.name = :u_name) OR (u.active = 1)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->equals('Doctrine');

        $query = $query->orWhere('active')->isTrue();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testGroupByMethod()
    {
        $expected = 'SELECT u.* FROM users u GROUP BY u.active';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->groupBy(array('active'));

        $this->assertEquals($expected, $query->__toString());
    }

    public function testHavingMethod()
    {
        $expected = 'SELECT u.* FROM users u HAVING u.name = :u_name';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->having('name')->equals('Doctrine');

        $this->assertEquals($expected, $query->__toString());
    }

    public function testAndHavingMethod()
    {
        $expected = 'SELECT u.* FROM users u HAVING (u.name = :u_name) AND (u.active = 1)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->having('name')->equals('Doctrine');

        $query = $query->andHaving('active')->isTrue();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testOrHavingMethod()
    {
        $expected = 'SELECT u.* FROM users u HAVING (u.name = :u_name) OR (u.active = 1)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->having('name')->equals('Doctrine');

        $query = $query->orHaving('active')->isTrue();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testAndOrderByMethod()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC, u.age DESC';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->orderBy('name')->andOrderBy('age')->descending();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testLimitMethod()
    {
        $expected = 'SELECT u.* FROM users u LIMIT 10 OFFSET 20';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->limit(10, 20);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testSqlMethod()
    {
        $expected = 'DELETE FROM users u WHERE u.id = :u_id';

        $query = new Query($this->builder);

        $query = $query->deleteFrom('users')->where('id')->equals(1);

        $this->assertEquals($expected, $query->sql());
    }

    public function testBindingsMethod()
    {
        $query = new Query($this->builder);

        $expected = array(':u_id' => 1);

        $query = $query->deleteFrom('users')->where('id')->equals(1);

        $this->assertEquals($expected, $query->bindings());
    }

    public function testTypesMethod()
    {
        $expected = array(':u_id' => 'integer');

        $query = new Query($this->builder);

        $query = $query->deleteFrom('users')->where('id')->equals(1);

        $this->assertEquals($expected, $query->types());
    }
}
