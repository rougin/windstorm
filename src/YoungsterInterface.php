<?php

namespace Rougin\Windstorm;

/**
 * Youngster Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface YoungsterInterface extends QueryInterface
{
    /**
     * Returns the field to store the result from the
     * child query instance and append it to the result
     * from the parent query instance as a single value.
     *
     * @return string
     */
    public function field();

    /**
     * Returns the identifier column from the child table.
     *
     * @return string
     */
    public function foreign();

    /**
     * Returns the identifier column from the parent table.
     *
     * @return string
     */
    public function local();

    /**
     * Returns the specified query instance.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function query();
}
