<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Create Entity Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class CreateEntity implements MutatorInterface
{
    const CREATED_AT = 'created_at';

    /**
     * @var array
     */
    protected $data = array();

    /**
     * @var string
     */
    protected $dateFormat = 'Y-m-d H:i:s';

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var boolean
     */
    protected $timestamp = true;

    /**
     * Initializes the mutator instance.
     *
     * @param array $data
     */
    public function __construct(array $data)
    {
        $this->data = $data;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        if ($this->timestamp)
        {
            $this->data[static::CREATED_AT] = date($this->dateFormat);
        }

        return $query->insertInto($this->table)->values($this->data);
    }
}
