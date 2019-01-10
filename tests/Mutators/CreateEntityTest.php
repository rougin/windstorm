<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\Fixture\Mutators\CreateUser;

/**
 * Create Entity Test
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CreateEntityTest extends TestCase
{
    /**
     * Tests MutatorInterface::set.
     *
     * @return void
     */
    public function testSetMethod()
    {
        $data = array('name' => 'MutatorInterface');

        $data['created_at'] = date('Y-m-d H:i:s');

        $result = $this->user->set(new CreateUser($data));

        $this->assertEquals(1, $result->affected());
    }
}
