<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\Mutators\ReturnEntities;

/**
 * Return User Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnUsers extends ReturnEntities
{
    /**
     * @var string
     */
    protected $table = 'users';
}
