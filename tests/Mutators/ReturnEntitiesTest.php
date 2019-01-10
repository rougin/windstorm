<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;

/**
 * Return Entities Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnEntitiesTest extends TestCase
{
    /**
     * Tests MutatorInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $expected = require __DIR__ . '/../Fixture/UserItems.php';

        $result = $this->user->set(new ReturnUsers);

        $this->assertEquals($expected, $result->items());
    }
}
