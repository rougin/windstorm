<?php

namespace Rougin\Windstorm;

/**
 * Result Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface ResultInterface
{
    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected();

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first();

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items();
}
