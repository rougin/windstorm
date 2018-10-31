<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
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
     * @var \Doctrine\DBAL\Query\QueryBuilder
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
     * @param \Rougin\Windstorm\Doctrine\Query  $query
     * @param \Doctrine\DBAL\Query\QueryBuilder $builder
     * @param string                            $table
     */
    public function __construct(Query $query, QueryBuilder $builder, $table)
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

            $data[$key] = '?';

            $index = $index + 1;
        }

        $this->builder->add('values', /** @scrutinizer ignore-type */ $data);

        return $this->query->builder($this->builder);
    }
}
