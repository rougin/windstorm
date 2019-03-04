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
     * Returns a result from a query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return self
     */
    public function execute(QueryInterface $query);

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first();

    /**
     * Returns the last inserted ID.
     *
     * @return integer
     */
    public function inserted();

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items();
}
