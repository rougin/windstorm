<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

/**
 * Order Query
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
     * @param \Rougin\Windstorm\Doctrine\Builder $builder
     */
    public function __construct(Builder $builder)
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
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

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
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->innerJoin($current, $table, $alias, $condition);

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
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->leftJoin($current, $table, $alias, $condition);

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
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->rightJoin($current, $table, $alias, $condition);

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
        $this->initial = '';

        $this->table = '';

        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

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
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = $table;

        return new Update($this, $this->builder, $table, $alias);
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
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = (string) $table;

        $this->builder->delete($table, $alias);

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
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key);
    }

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key, 'AND');
    }

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key, 'OR');
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
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key);
    }

    /**
     * Generates an AND HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function andHaving($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key, 'AND');
    }

    /**
     * Generates an OR HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function orHaving($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key, 'OR');
    }

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Order($this, $this->builder, $key);
    }

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Order($this, $this->builder, $key, 'ADD');
    }

    /**
     * Performs a LIMIT query.
     *
     * NOTE: If not supported by a database engine, it should
     * having at least a query returning a limited result set
     * and a query for returning a limited offset result.
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
     * @param  \Rougin\Windstorm\Doctrine\Builder $builder
     * @return self
     */
    public function builder(Builder $builder)
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
}
