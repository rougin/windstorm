<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\QueryInterface;

/**
 * Relation
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class Relation
{
    /**
     * @var array
     */
    protected $alias = array();

    /**
     * @var array
     */
    protected $fields = array();

    /**
     * @var string|null
     */
    protected $foreign = null;

    /**
     * @var string|null
     */
    protected $primary = null;

    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * Initializes the relation interface.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function __construct(QueryInterface $query)
    {
        $this->fields[] = array();

        $this->fields[] = array();

        $this->query = $query;
    }

    /**
     * Sets the field/column of a foreign/primary table.
     *
     * @param  integer $type
     * @param  string $name
     * @return self
     */
    public function field($type, $name)
    {
        $this->fields[$type][] = $name;
    }

    /**
     * Sets the fields of a foreign/primary table.
     *
     * @param  integer  $type
     * @param  string[] $values
     * @return self
     */
    public function fields($type, array $values)
    {
        $this->fields[$type] = array();

        foreach ($values as $field)
        {
            $this->field($type, $field);
        }

        return $this;
    }

    /**
     * Sets the foreign table.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function foreign($table, $alias = null)
    {
        $this->foreign = $table;

        $this->alias[1] = $alias ?: $table[0];
    }

    /**
     * Sets the primary table.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function primary($table, $alias = null)
    {
        $this->primary = $table;

        $this->alias[0] = $alias ?: $table[0];
    }

    /**
     * Parses specified fields as table columns.
     *
     * @param  integer $type
     * @param  boolean $prefix
     * @return array
     */
    protected function columns($type, $prefix = true)
    {
        $alias = $this->alias[$type];

        $columns = array();

        foreach ($this->fields[$type] as $value)
        {
            if ($type === 1 && $prefix)
            {
                $column = $alias . '_' . $value;

                $value .= " as $column";
            }

            $columns[] = $alias . '.' . $value;
        }

        return (array) $columns;
    }
}
