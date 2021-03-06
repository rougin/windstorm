<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\Mutators\UpdateEntity;

/**
 * Update User Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UpdateUser extends UpdateEntity
{
    /**
     * @var string
     */
    protected $table = 'users';
}
