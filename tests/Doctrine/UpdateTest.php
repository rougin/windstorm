<?php

namespace Rougin\Windstorm\Doctrine;

class UpdateTest extends TestCase
{
    public function testSetMethod()
    {
        $expected = 'UPDATE users u SET name = ? WHERE u.id = ?';

        $query = new Query($this->builder);

        $query = $query->update('users')->set('name', 'Windstorm');

        $query = $query->where('id')->equals(1);

        $this->assertEquals($expected, $query->__toString());
    }
}