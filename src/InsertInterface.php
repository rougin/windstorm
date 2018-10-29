<?php

namespace Rougin\Windstorm;

/**
 * Having Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface InsertInterface
{
    /**
     * Sets the values to be inserted.
     *
     * @param  array  $data
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function values(array $data);
}
