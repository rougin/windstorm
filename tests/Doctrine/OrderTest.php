<?php

namespace Rougin\Windstorm\Doctrine;

class OrderTest extends TestCase
{
    public function testAscendingMethod()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->orderBy('name')->ascending();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testDescendingMethod()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name DESC';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->orderBy('name')->descending();

        $this->assertEquals($expected, $query->__toString());
    }

    public function testCallMagicMethod()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->orderBy('name');

        $this->assertEquals($expected, (string) $query->sql());
    }

    public function testToStringMagicMethod()
    {
        $expected = 'SELECT u.* FROM users u ORDER BY u.name ASC';

        $query = new Query($this->builder);

        $query = $query->select(array('u.*'))->from('users');

        $query = $query->orderBy('name');

        $this->assertEquals($expected, $query->__toString());
    }
}
