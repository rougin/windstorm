<?php

namespace Rougin\Windstorm\Eloquent;

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
        $expected = 'select * from "users" order by "name" asc';

        $query = $this->query->select(array('*'))->from('users');

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
        $expected = 'select * from "users" order by "name" desc';

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
        $expected = 'select * from "users" order by "name" asc';

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
        $expected = 'select * from "users" order by "name" asc';

        $query = $this->query->select(array('*'));

        $result = (string) $query->from('users')->orderBy('name');

        $this->assertEquals($expected, $result);
    }
}
