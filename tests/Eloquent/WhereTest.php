<?php

namespace Rougin\Windstorm\Eloquent;

/**
 * Where Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class WhereTest extends TestCase
{
    /**
     * Tests WhereInterface::equals.
     *
     * @return void
     */
    public function testEqualsMethod()
    {
        $expected = 'select * from "users" where "id" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = (string) $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::notEqualTo.
     *
     * @return void
     */
    public function testNotEqualToMethod()
    {
        $expected = 'select * from "users" where "id" != ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->notEqualTo(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::greaterThan.
     *
     * @return void
     */
    public function testGreaterThanMethod()
    {
        $expected = 'select * from "users" where "id" > ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->greaterThan(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::greaterThanOrEqualTo.
     *
     * @return void
     */
    public function testGreaterThanOrEqualToMethod()
    {
        $expected = 'select * from "users" where "id" >= ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->greaterThanOrEqualTo(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::in.
     *
     * @return void
     */
    public function testInMethod()
    {
        $expected = 'select * from "users" where "id" in (?, ?, ?)';

        $query = $this->query->select(array('*'))->from('users');

        $result = (string) $query->where('id')->in(array(1, 2, 3))->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::notIn.
     *
     * @return void
     */
    public function testNotInMethod()
    {
        $expected = 'select * from "users" where "id" not in (?, ?, ?)';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->notIn(array(1, 2, 3))->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::isFalse.
     *
     * @return void
     */
    public function testIsFalseMethod()
    {
        $expected = 'select * from "users" where "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('active')->isFalse()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::isNotNull.
     *
     * @return void
     */
    public function testIsNotNullMethod()
    {
        $expected = 'select * from "users" where "name" is not null';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->isNotNull()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::isNull.
     *
     * @return void
     */
    public function testIsNullMethod()
    {
        $expected = 'select * from "users" where "name" is null';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->isNull()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::isTrue.
     *
     * @return void
     */
    public function testIsTrueMethod()
    {
        $expected = 'select * from "users" where "active" = ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('active')->isTrue()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::lessThan.
     *
     * @return void
     */
    public function testLessThanMethod()
    {
        $expected = 'select * from "users" where "id" < ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->lessThan(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::lessThanOrEqualTo.
     *
     * @return void
     */
    public function testLessThanOrEqualToMethod()
    {
        $expected = 'select * from "users" where "id" <= ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('id')->lessThanOrEqualTo(1)->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::like.
     *
     * @return void
     */
    public function testLikeMethod()
    {
        $expected = 'select * from "users" where "name" like ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->like('%Eloquent%')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::notLike.
     *
     * @return void
     */
    public function testNotLikeMethod()
    {
        $expected = 'select * from "users" where "name" not like ?';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->notLike('%Eloquent%')->sql();

        $this->assertEquals($expected, $result);
    }
}
