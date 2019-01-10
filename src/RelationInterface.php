<?php

namespace Rougin\Windstorm;

/**
 * Relation Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface RelationInterface
{
    const TYPE_LOCAL = 0;

    const TYPE_FOREIGN = 1;

    /**
     * Sets the field/column of a foreign/local table.
     *
     * @param  integer $type
     * @param  string $name
     * @return self
     */
    public function field($type, $name);

    /**
     * Sets the fields of a foreign/local table.
     *
     * @param  integer  $type
     * @param  string[] $values
     * @return self
     */
    public function fields($type, array $values);

    /**
     * Sets the foreign table.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function foreign($table, $alias = null);

    /**
     * Sets the local table.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function local($table, $alias = null);

    /**
     * Generates the query instance from relation.
     *
     * @param  string $local
     * @param  string $foreign
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function make($local, $foreign);
}
