<?php

namespace Rougin\Windstorm;

/**
 * Mapper Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface MapperInterface
{
    /**
     * Maps the result data into a class.
     *
     * @param  array $data
     * @return mixed
     */
    public function map(array $data);
}
