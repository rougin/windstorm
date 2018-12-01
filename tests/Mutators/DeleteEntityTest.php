<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\Fixture\Mutators\DeleteUser;

/**
 * Delete Entity Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DeleteEntityTest extends TestCase
{
    /**
     * Tests MutatorInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $result = $this->user->mutate(new DeleteUser(4));

        $this->assertEquals(1, $result->affected());
    }
}
