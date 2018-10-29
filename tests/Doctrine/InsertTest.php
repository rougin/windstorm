<?php

namespace Rougin\Windstorm\Doctrine;

class InsertTest extends TestCase
{
    public function testValuesMethod()
    {
        $expected = 'INSERT INTO users (name) VALUES (?)';

        $query = new Query($this->builder);

        $data = array('name' => 'Doctrine');

        $query = $query->insertInto('users')->values($data);

        $this->assertEquals($expected, $query->__toString());
    }
}
