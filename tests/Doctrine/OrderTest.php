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
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = $this->query->select(array('u.*'))->from('users');

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
        $expected = 'SELECT u.* FROM users u ORDER BY u.name DESC';

        $query = $this->query->select(array('u.*'))->from('users');

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
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = $this->query->select(array('u.*'));

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
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = $this->query->select(array('u.*'));

        $result = (string) $query->from('users')->orderBy('name');

        $this->assertEquals($expected, $result);
    }
}
