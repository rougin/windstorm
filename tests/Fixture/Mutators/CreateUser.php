<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\Mutators\CreateEntity;

/**
 * Create User Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CreateUser extends CreateEntity
{
    /**
     * @var string
     */
    protected $table = 'users';
}
