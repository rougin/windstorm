<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\Fixture\Mutators\ReturnUsers;
use Rougin\Windstorm\Fixture\Entities\User;

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

    /**
     * Tests MutatorInterface::set without limit.
     *
     * @return void
     */
    public function testSetMethodWithoutLimit()
    {
        $expected = require __DIR__ . '/../Fixture/UserItems.php';

        $result = $this->user->set(new ReturnUsers(null));

        $this->assertEquals($expected, $result->items());
    }

    /**
     * Tests MutatorInterface::set with where conditions.
     *
     * @return void
     */
    public function testSetMethodWithWheres()
    {
        $expected = array(new User(1, 'Windstorm'));

        $mutator = new ReturnUsers;

        $mutator->where('name', 'Windstorm');

        $result = $this->user->set($mutator)->items();

        $this->assertEquals($expected, $result);
    }
}
