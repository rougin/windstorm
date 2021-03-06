<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\Mutators\DeleteEntity;

/**
 * Delete User Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DeleteUser extends DeleteEntity
{
    /**
     * @var string
     */
    protected $table = 'users';
}
