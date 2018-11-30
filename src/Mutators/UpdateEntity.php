<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Update Entity Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UpdateEntity implements MutatorInterface
{
    /**
     * @var array
     */
    protected $data = array();

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
     * @param array   $data
     */
    public function __construct($id, $data)
    {
        $this->id = $id;

        $this->data = $data;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $query = $query->update($this->table);

        foreach ($this->data as $key => $value)
        {
            $query = $query->set($key, $value);
        }

        $query = $query->where($this->primary);

        return $query->equals((integer) $this->id);
    }
}
