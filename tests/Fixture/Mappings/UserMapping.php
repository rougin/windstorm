<?php

namespace Rougin\Windstorm\Fixture\Mappings;

use Rougin\Windstorm\Fixture\Entities\User;
use Rougin\Windstorm\MappingInterface;

/**
 * User Mapping
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UserMapping implements MappingInterface
{
    /**
     * Maps the result data into a class.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function map($data)
    {
        return new User($data['id'], $data['name']);
    }
}
