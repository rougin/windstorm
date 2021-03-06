<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Return Entity Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnEntity implements MutatorInterface
{
    /**
     * @var string
     */
    protected $alias = '';

    /**
     * @var string[]
     */
    protected $fields = array('*');

    /**
     * @var integer
     */
    protected $id;

    /**
     * @var string
     */
    protected $primary = 'id';

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Initializes the mutator instance.
     *
     * @param integer $id
     * @param boolean $array
     */
    public function __construct($id, $array = false)
    {
        $this->id = $id;

        $this->array = $array;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        if (! $this->alias && $this->table)
        {
            $this->alias = $this->table[0];
        }

        if ($this->array === true)
        {
            $this->fields[] = '0 as ' . $this->alias . '_array';
        }

        $query = $this->query($query);

        return $query->where($this->primary)->equals($this->id);
    }

    /**
     * Sets a predefined query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\QueryInterface
     */
    protected function query(QueryInterface $query)
    {
        return $query->select($this->fields)->from($this->table, $this->alias);
    }
}
