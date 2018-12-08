<?php

namespace Rougin\Windstorm\Eloquent;

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
        $expected = 'insert into "users" ("name") values (?)';

        $data = array('name' => 'Eloquent');

        $query = $this->query->insertInto('users');

        $result = $query->values($data)->sql();

        $this->assertEquals($expected, $result);
    }
}
