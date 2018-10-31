<?php

namespace Rougin\Windstorm\Doctrine;

/**
 * Insert Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class InsertTest extends TestCase
{
    /**
     * Tests InsertInterface::values.
     *
     * @return void
     */
    public function testValuesMethod()
    {
        $expected = 'INSERT INTO users (name) VALUES (?)';

        $data = array('name' => 'Doctrine');

        $query = $this->query->insertInto('users');

        $result = $query->values($data)->sql();

        $this->assertEquals($expected, $result);
    }
}
