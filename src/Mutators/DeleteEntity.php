<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Delete Entity Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class DeleteEntity implements MutatorInterface
{
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
     */
    public function __construct($id)
    {
        $this->id = $id;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $query = $query->deleteFrom((string) $this->table);

        return $query->where($this->primary)->equals($this->id);
    }
}
