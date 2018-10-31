<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

/**
 * Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Query implements QueryInterface
{
    /**
     * @var \Rougin\Windstorm\Doctrine\Builder
     */
    protected $builder;

    /**
     * @var string
     */
    protected $initial = '';

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sql();
    }

    /**
     * Initializes the query instance.
     *
     * @param \Doctrine\DBAL\Query\QueryBuilder $builder
     */
    public function __construct(QueryBuilder $builder)
    {
        $this->builder = $builder;
    }

    /**
     * Generates a SELECT query.
     *
     * @param  array  $fields
     * @return self
     */
    public function select(array $fields)
    {
        $this->reset();

        $this->builder->select($fields);

        return $this;
    }

    /**
     * Generates a FROM query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function from($table, $alias = null)
    {
        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = $table;

        $this->builder->from($table, $alias);

        return $this;
    }

    /**
     * Generates an INNER JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function innerJoin($table, $local, $foreign)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign);

        $this->builder->innerJoin($this->initial, $table, $alias, $where);

        return $this;
    }

    /**
     * Generates a LEFT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function leftJoin($table, $local, $foreign)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign);

        $this->builder->leftJoin($this->initial, $table, $alias, $where);

        return $this;
    }

    /**
     * Generates a RIGHT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function rightJoin($table, $local, $foreign)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign);

        $this->builder->rightJoin($this->initial, $table, $alias, $where);

        return $this;
    }

    /**
     * Generates an INSERT INTO query.
     *
     * @param  string $table
     * @return \Rougin\Windstorm\InsertInterface
     */
    public function insertInto($table)
    {
        $this->reset();

        return new Insert($this, $this->builder, $table);
    }

    /**
     * Generates an UPDATE query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return \Rougin\Windstorm\UpdateInterface
     */
    public function update($table, $alias = null)
    {
        $this->reset();

        $initial = $this->alias($table);

        $this->initial = (string) $initial;

        $this->table = (string) $table;

        return new Update($this, $this->builder, $table, $initial);
    }

    /**
     * Generates a DELETE FROM query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function deleteFrom($table, $alias = null)
    {
        $this->reset();

        $this->initial = $this->alias((string) $table);

        $this->table = $table;

        $this->builder->delete($table, $this->initial);

        return $this;
    }

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key)
    {
        return new Where($this, $this->builder, $key, $this->initial);
    }

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key)
    {
        return new Where($this, $this->builder, $key, $this->initial, 'AND');
    }

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key)
    {
        return new Where($this, $this->builder, $key, $this->initial, 'OR');
    }

    /**
     * Generates a GROUP BY query.
     *
     * @param  array $fields
     * @return self
     */
    public function groupBy(array $fields)
    {
        foreach ($fields as $key => $field)
        {
            if (strpos($field, '.') === false)
            {
                $fields[$key] = $this->initial . '.' . $field;
            }
        }

        $this->builder->groupBy($fields);

        return $this;
    }

    /**
     * Generates a HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function having($key)
    {
        return new Having($this, $this->builder, $key, $this->initial);
    }

    /**
     * Generates an AND HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function andHaving($key)
    {
        return new Having($this, $this->builder, $key, $this->initial, 'AND');
    }

    /**
     * Generates an OR HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function orHaving($key)
    {
        return new Having($this, $this->builder, $key, $this->initial, 'OR');
    }

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key)
    {
        return new Order($this, $this->builder, $key, $this->initial);
    }

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key)
    {
        return new Order($this, $this->builder, $key, $this->initial, 'ADD');
    }

    /**
     * Performs a LIMIT query.
     *
     * @param  integer      $limit
     * @param  integer|null $offset
     * @return self
     */
    public function limit($limit, $offset = null)
    {
        $this->builder->setMaxResults($limit);

        if ($offset !== null)
        {
            $this->builder->setFirstResult($offset);
        }

        return $this;
    }

    /**
     * Sets the Builder instance.
     *
     * @param  \Doctrine\DBAL\Query\QueryBuilder $builder
     * @return self
     */
    public function builder(QueryBuilder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function sql()
    {
        return $this->builder->getSql();
    }

    public function bindings()
    {
        return $this->builder->getParameters();
    }

    /**
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function types()
    {
        return $this->builder->getParameterTypes();
    }

    /**
     * Returns an available table alias.
     *
     * @param  string $table
     * @return string
     */
    protected function alias($table)
    {
        $characters = str_split($table);

        $result = $characters[0];

        foreach ($characters as $character)
        {
            $character = strtolower($character);

            if ($this->initial !== $character)
            {
                $result = $character; break;
            }
        }

        return (string) $result;
    }

    /**
     * Returns a JOIN condition.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return string
     */
    protected function condition($table, $local, $foreign)
    {
        $condition = (string) $this->initial . '.' . $local;

        $alias = $this->alias((string) $table);

        $condition .= ' = ' . $alias . '.' . $foreign;

        return array($alias, (string) $condition);
    }

    /**
     * Resets the whole query builder.
     *
     * @return self
     */
    public function reset()
    {
        $this->builder->setMaxResults(null);

        $this->builder->setFirstResult(null);

        $this->initial = (string) '';

        $this->builder->resetQueryParts();

        $this->table = (string) '';

        $this->builder->setParameters(array());

        return $this;
    }
}
