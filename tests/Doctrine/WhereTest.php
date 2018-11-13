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
        $expected = 'SELECT * FROM users WHERE id = :id';

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
        $expected = 'SELECT * FROM users WHERE id <> :id';

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
        $expected = 'SELECT * FROM users WHERE id > :id';

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
        $expected = 'SELECT * FROM users WHERE id >= :id';

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
        $expected = 'SELECT * FROM users WHERE id IN (:id_0, :id_1, :id_2)';

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
        $expected = 'SELECT * FROM users WHERE id NOT IN (:id_0, :id_1, :id_2)';

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
        $expected = 'SELECT * FROM users WHERE active = 0';

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
        $expected = 'SELECT * FROM users WHERE name IS NOT NULL';

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
        $expected = 'SELECT * FROM users WHERE name IS NULL';

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
        $expected = 'SELECT * FROM users WHERE active = 1';

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
        $expected = 'SELECT * FROM users WHERE id < :id';

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
        $expected = 'SELECT * FROM users WHERE id <= :id';

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
        $expected = 'SELECT * FROM users WHERE name LIKE :name';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->like('%Doctrine%')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests WhereInterface::notLike.
     *
     * @return void
     */
    public function testNotLikeMethod()
    {
        $expected = 'SELECT * FROM users WHERE name NOT LIKE :name';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->where('name')->notLike('%Doctrine%')->sql();

        $this->assertEquals($expected, $result);
    }
}
