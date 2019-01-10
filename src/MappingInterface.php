<?php

namespace Rougin\Windstorm;

/**
 * Mapping Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface MappingInterface
{
    /**
     * Maps the result data into a class.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function map($data);
}
