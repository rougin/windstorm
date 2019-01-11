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
     * @var \Doctrine\DBAL\Query\QueryBuilder
     */
    protected $builder;

    /**
     * @var string|null
     */
    protected $initial = null;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var integer
     */
    protected $type = self::TYPE_SELECT;

    /**
     * Clones the builder instance.
     *
     * @return void
     */
    public function __clone()
    {
        $this->builder = clone $this->builder;
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
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sql();
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
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function bindings()
    {
        return $this->builder->getParameters();
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
     * Generates a DELETE FROM query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function deleteFrom($table, $alias = null)
    {
        $this->reset();

        $this->initial = $alias;

        $this->table = $table;

        $this->type = self::TYPE_DELETE;

        $this->builder->delete($table, $this->initial);

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
        $this->initial = $alias;

        $this->table = $table;

        $this->type = self::TYPE_SELECT;

        $this->builder->from($table, $alias);

        return $this;
    }

    /**
     * Generates a GROUP BY query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function groupBy($fields)
    {
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
     * Generates an INNER JOIN query.
     *
     * @param  string      $table
     * @param  string      $local
     * @param  string      $foreign
     * @param  string|null $alias
     * @return self
     */
    public function innerJoin($table, $local, $foreign, $alias = null)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign, $alias);

        $this->builder->innerJoin($this->initial, $table, $alias, $where);

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

        $this->type = self::TYPE_INSERT;

        return new Insert($this, $this->builder, $table);
    }

    /**
     * Returns the instance of the query builder, if available.
     *
     * @return mixed
     */
    public function instance()
    {
        return $this->builder;
    }

    /**
     * Generates a LEFT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @param
     * @return self
     */
    public function leftJoin($table, $local, $foreign, $alias = null)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign, $alias);

        $this->builder->leftJoin($this->initial, $table, $alias, $where);

        return $this;
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
     * Generates a RIGHT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @param
     * @return self
     */
    public function rightJoin($table, $local, $foreign, $alias = null)
    {
        list($alias, $where) = $this->condition($table, $local, $foreign, $alias);

        $this->builder->rightJoin($this->initial, $table, $alias, $where);

        return $this;
    }

    /**
     * Generates a SELECT query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function select($fields)
    {
        $this->reset();

        $this->type = self::TYPE_SELECT;

        $this->builder->select($fields);

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

    /**
     * Returns the table name from the query.
     *
     * @return string
     */
    public function table()
    {
        return $this->table;
    }

    /**
     * Returns the type of the query.
     *
     * @return integer
     */
    public function type()
    {
        return $this->type;
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

        $this->type = self::TYPE_UPDATE;

        list($this->initial, $this->table) = array($alias, $table);

        return new Update($this, $this->builder, $table, $alias);
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
     * @param  string      $table
     * @param  string      $local
     * @param  string      $foreign
     * @param  string|null $alias
     * @return string
     */
    protected function condition($table, $local, $foreign, $alias = null)
    {
        if (strpos($local, '.') === false)
        {
            $local = $this->initial . '.' . $local;
        }

        if ($alias === null)
        {
            $alias = $this->alias((string) $table);
        }

        $local .= ' = ' . $alias . '.' . $foreign;

        return array($alias, (string) $local);
    }

    /**
     * Resets the whole query builder.
     *
     * @return self
     */
    protected function reset()
    {
        $this->builder->setMaxResults(null);

        $this->builder->setFirstResult(null);

        $this->initial = (string) '';

        $this->builder->resetQueryParts();

        $this->table = (string) '';

        $this->builder->setParameters(array());

        $this->type = self::TYPE_SELECT;

        return $this;
    }
}
