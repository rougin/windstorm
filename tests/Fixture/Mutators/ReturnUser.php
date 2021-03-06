<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\Mutators\ReturnEntity;

/**
 * Return User Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnUser extends ReturnEntity
{
    /**
     * @var string
     */
    protected $table = 'users';
}
