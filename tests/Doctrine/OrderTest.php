<?php

namespace Rougin\Windstorm\Doctrine;

/**
 * Order Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class OrderTest extends TestCase
{
    /**
     * Tests OrderInterface::ascending.
     *
     * @return void
     */
    public function testAscendingMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name ASC';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->orderBy('name')->ascending()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests OrderInterface::ascending with a table alias.
     *
     * @return void
     */
    public function testAscendingMethodWithTableAlias()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = $this->query->select(array('u.*'))->from('users', 'u');

        $result = $query->orderBy('name')->ascending()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests OrderInterface::descending.
     *
     * @return void
     */
    public function testDescendingMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name DESC';

        $query = $this->query->select(array('*'))->from('users');

        $result = $query->orderBy('name')->descending()->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests OrderInterface::__call.
     *
     * @return void
     */
    public function testCallMagicMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name ASC';

        $query = $this->query->select(array('*'));

        $result = $query->from('users')->orderBy('name')->sql();

        $this->assertEquals($expected, $result);
    }

    /**
     * Tests OrderInterface::__toString.
     *
     * @return void
     */
    public function testToStringMagicMethod()
    {
        $expected = 'SELECT * FROM users ORDER BY name ASC';

        $query = $this->query->select(array('*'));

        $result = (string) $query->from('users')->orderBy('name');

        $this->assertEquals($expected, $result);
    }
}
