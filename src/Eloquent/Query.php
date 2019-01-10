<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Rougin\Windstorm\QueryInterface;

/**
 * Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Query implements QueryInterface
{
    /**
     * @var array
     */
    protected $bindings = array();

    /**
     * @var \Illuminate\Database\Eloquent\Builder
     */
    protected $builder;

    /**
     * @var string
     */
    protected $sql = '';

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
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function __construct(Model $model)
    {
        $this->builder = $model->newQuery();
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
        return new Having($this, $this->builder, $key, 'and');
    }

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key)
    {
        return new Order($this, $this->builder, $key);
    }

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key)
    {
        return new Where($this, $this->builder, $key, 'and');
    }

    /**
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function bindings()
    {
        if (empty($this->bindings))
        {
            return $this->builder->getBindings();
        }

        return $this->bindings;
    }

    /**
     * Sets the builder instance.
     *
     * @param  \Illuminate\Database\Query\Builder $builder
     * @return self
     */
    public function builder(Builder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Sets the data with new values.
     *
     * @param  array $data
     * @return self
     */
    public function data(array $data)
    {
        $this->bindings = $data;

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
        $this->type = self::TYPE_DELETE;

        $this->table = (string) $table;

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
        $this->builder = $this->builder->from($table);

        $this->table = (string) $table;

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
        $this->builder = $this->builder->groupBy($fields);

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
        return new Having($this, $this->builder, $key);
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
        $this->builder = $this->builder->join($table, $local, '=', $foreign);

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
        $this->type = (integer) self::TYPE_INSERT;

        return new Insert($this, $this->builder);
    }

    /**
     * Returns the model instance.
     *
     * @return \Illuminate\Database\Eloquent\Builder
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
     * @return self
     */
    public function leftJoin($table, $local, $foreign)
    {
        $this->builder = $this->builder->join($table, $local, '=', $foreign, 'left');

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
        $this->builder = $this->builder->limit($limit);

        if ($offset)
        {
            $this->builder = $this->builder->offset($offset);
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
        return new Having($this, $this->builder, $key, 'or');
    }

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key)
    {
        return new Where($this, $this->builder, $key, 'or');
    }

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key)
    {
        return new Order($this, $this->builder, $key);
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
        $this->builder = $this->builder->join($table, $local, '=', $foreign, 'right');

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
        $this->builder = $this->builder->select($fields);

        $this->type = self::TYPE_SELECT;

        return $this;
    }

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function sql()
    {
        $query = $this->builder->getQuery();

        switch ($this->type)
        {
            case QueryInterface::TYPE_INSERT:
                $grammar = $query->getGrammar();

                return $grammar->compileInsert($query, $this->bindings);
            case QueryInterface::TYPE_UPDATE:
                $grammar = $query->getGrammar();

                return $grammar->compileUpdate($query, $this->bindings);
            case QueryInterface::TYPE_DELETE:
                $grammar = $query->getGrammar();

                return $grammar->compileDelete($query);
        }

        return (string) $this->builder->toSql();
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
        $this->type = self::TYPE_UPDATE;

        return new Update($this, $this->builder);
    }

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key)
    {
        return new Where($this, $this->builder, $key, 'and');
    }
}
