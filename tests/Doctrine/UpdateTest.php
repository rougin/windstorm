<?php

namespace Rougin\Windstorm\Doctrine;

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
        $expected = 'UPDATE users u SET u.name = :u_name WHERE u.id = :u_id';

        $query = $this->query->update('users')->set('name', 'Windstorm');

        $result = (string) $query->where('id')->equals(1)->sql();

        $this->assertEquals($expected, $result);
    }
}
