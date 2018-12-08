<?php

namespace Rougin\Windstorm\Eloquent;

/**
 * Update Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UpdateTest extends TestCase
{
    /**
     * Tests UpdateInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $expected = 'update "users" set "name" = ? where "id" = ?';

        $query = $this->query->update('users')->set('name', 'Windstorm');

        $result = (string) $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }
}
