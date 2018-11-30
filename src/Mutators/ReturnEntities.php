<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Return Entities Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnEntities implements MutatorInterface
{
    /**
     * @var string[]
     */
    protected $fields = array('*');

    /**
     * @var integer
     */
    protected $offset = 0;

    /**
     * @var integer
     */
    protected $limit = 10;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Initializes the mutator instance.
     *
     * @param integer $limit
     * @param integer $offset
     */
    public function __construct($limit = 10, $offset = 0)
    {
        $this->limit = $limit;

        $this->offset = $offset;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        $query = $query->select($this->fields)->from($this->table);

        return $query->limit($this->limit, (integer) $this->offset);
    }
}
