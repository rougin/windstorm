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
     * Executes an SQL statement with its bindings and types.
     *
     * @param  string $sql
     * @param  array  $bindings
     * @param  array  $types
     * @return mixed
     */
    public function execute($sql, array $bindings, array $types);
}
