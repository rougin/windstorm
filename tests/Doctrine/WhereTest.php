<?php

namespace Rougin\Windstorm\Doctrine;

class WhereTest extends TestCase
{
    public function testEqualsMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id = :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->equals(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testNotEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id <> :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->notEqualTo(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testGreaterThanMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id > :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->greaterThan(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testGreaterThanOrEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id >= :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->greaterThanOrEqualTo(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testInMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id IN (:u_id_0, :u_id_1, :u_id_2)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->in(array(1, 2, 3));

        $this->assertEquals($expected, $query->__toString());
    }

    public function testNotInMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id NOT IN (:u_id_0, :u_id_1, :u_id_2)';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->notIn(array(1, 2, 3));

        $this->assertEquals($expected, $query->__toString());
    }

    public function testIsFalseMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.active = 0';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('active')->isFalse();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testIsNotNullMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name IS NOT NULL';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->isNotNull();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testIsNullMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name IS NULL';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->isNull();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testIsTrueMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.active = 1';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('active')->isTrue();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testLessThanMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id < :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->lessThan(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testLessThanOrEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id <= :u_id';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('id')->lessThanOrEqualTo(1);

        $this->assertEquals($expected, $query->__toString());
    }

    public function testLikeMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name LIKE :u_name';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->like('%Doctrine%');

        $this->assertEquals($expected, $query->__toString());
    }

    public function testNotLikeMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name NOT LIKE :u_name';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->where('name')->notLike('%Doctrine%');

        $this->assertEquals($expected, $query->__toString());
    }
}
