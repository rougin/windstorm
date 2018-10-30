<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\InsertInterface;

/**
 * Insert Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Insert implements InsertInterface
{
    /**
     * @var \Rougin\Windstorm\Doctrine\Builder
     */
    protected $builder;

    /**
     * @var \Rougin\Windstorm\Doctrine\Query
     */
    protected $query;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Doctrine\Query   $query
     * @param \Rougin\Windstorm\Doctrine\Builder $builder
     * @param string                             $table
     */
    public function __construct(Query $query, Builder $builder, $table)
    {
        $this->builder = $builder;

        $this->query = $query;

        $this->table = $table;
    }

    /**
     * Sets the values to be inserted.
     *
     * @param  array  $data
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function values(array $data)
    {
        $this->builder->insert($this->table);

        $index = 0;

        foreach ($data as $key => $value)
        {
            $this->builder->setParameter($index, $value);

            $index = $index + 1;

            $data[$key] = (string) '?';
        }

        $this->builder->add('values', (array) $data);

        return $this->query->builder($this->builder);
    }
}
