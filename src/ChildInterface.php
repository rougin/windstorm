<?php

namespace Rougin\Windstorm;

/**
 * Child Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface ChildInterface extends QueryInterface
{
    /**
     * Returns the identifier column for identifying children from the parent table.
     *
     * @return string
     */
    public function column();

    /**
     * Returns the identifier column from the child table.
     *
     * @return string
     */
    public function foreign();
}
