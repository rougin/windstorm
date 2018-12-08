<?php

namespace Rougin\Windstorm\Fixture;

use Rougin\Windstorm\MapperInterface;

/**
 * User Mapper
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UserMapper implements MapperInterface
{
    /**
     * Maps the result data into a class.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function map($data)
    {
        return new UserEntity($data['id'], $data['name']);
    }
}