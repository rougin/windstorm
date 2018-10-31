<?php

namespace Rougin\Windstorm\Doctrine;

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
        $expected = 'SELECT u.* FROM users u WHERE u.id = :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = (string) $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::notEqualTo.
     *
     * @return void
     */
    public function testNotEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id <> :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->notEqualTo(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::greaterThan.
     *
     * @return void
     */
    public function testGreaterThanMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id > :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->greaterThan(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::greaterThanOrEqualTo.
     *
     * @return void
     */
    public function testGreaterThanOrEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id >= :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->greaterThanOrEqualTo(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::in.
     *
     * @return void
     */
    public function testInMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id IN (:u_id_0, :u_id_1, :u_id_2)';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = (string) $query->where('id')->in(array(1, 2, 3))->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::notIn.
     *
     * @return void
     */
    public function testNotInMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id NOT IN (:u_id_0, :u_id_1, :u_id_2)';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->notIn(array(1, 2, 3))->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::isFalse.
     *
     * @return void
     */
    public function testIsFalseMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.active = 0';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('active')->isFalse()->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::isNotNull.
     *
     * @return void
     */
    public function testIsNotNullMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name IS NOT NULL';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('name')->isNotNull()->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::isNull.
     *
     * @return void
     */
    public function testIsNullMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name IS NULL';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('name')->isNull()->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::isTrue.
     *
     * @return void
     */
    public function testIsTrueMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.active = 1';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('active')->isTrue()->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::lessThan.
     *
     * @return void
     */
    public function testLessThanMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id < :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->lessThan(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::lessThanOrEqualTo.
     *
     * @return void
     */
    public function testLessThanOrEqualToMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.id <= :u_id';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('id')->lessThanOrEqualTo(1)->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::like.
     *
     * @return void
     */
    public function testLikeMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name LIKE :u_name';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('name')->like('%Doctrine%')->sql();

        $this->assertEquals($expected, $query);
    }

    /**
     * Tests WhereInterface::notLike.
     *
     * @return void
     */
    public function testNotLikeMethod()
    {
        $expected = 'SELECT u.* FROM users u WHERE u.name NOT LIKE :u_name';

        $query = $this->query->select(array('u.*'))->from('users');

        $result = $query->where('name')->notLike('%Doctrine%')->sql();

        $this->assertEquals($expected, $query);
    }
}
