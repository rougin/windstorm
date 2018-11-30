<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Rougin\Windstorm\QueryInterface;

class Query implements QueryInterface
{
    protected $model;

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->sql();
    }

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function builder(Builder $builder)
    {
        $this->model = $builder;

        return $this;
    }

    /**
     * Generates a SELECT query.
     *
     * @param  array  $fields
     * @return self
     */
    public function select(array $fields)
    {
        $this->model = $this->model->select($fields);

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
        $this->model = $this->model->from($table);

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
        $this->model = $this->model->join($table, $local, '=', $foreign);

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
        $this->model = $this->model->join($table, $local, '=', $foreign, 'left');

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
        $this->model = $this->model->join($table, $local, '=', $foreign, 'right');

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
    }

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key)
    {
        return new Where($this, $this->model, $key, 'and');
    }

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key)
    {
        return new Where($this, $this->model, $key, 'and');
    }

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key)
    {
        return new Where($this, $this->model, $key, 'or');
    }

    /**
     * Generates a GROUP BY query.
     *
     * @param  array $fields
     * @return self
     */
    public function groupBy(array $fields)
    {
        $this->model = $this->model->groupBy($fields);

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
        return new Having($this, $this->model, $key);
    }

    /**
     * Generates an AND HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function andHaving($key)
    {
        return new Having($this, $this->model, $key, 'and');
    }

    /**
     * Generates an OR HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function orHaving($key)
    {
        return new Having($this, $this->model, $key, 'or');
    }

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key)
    {
        return new Order($this, $this->model, $key);
    }

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key)
    {
        return new Order($this, $this->model, $key);
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
        $this->model = $this->model->limit($limit);

        if ($offset)
        {
            $this->model = $this->model->offset($offset);
        }

        return $this;
    }

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function sql()
    {
        return $this->model->toSql();
    }

    /**
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function bindings()
    {
        return $this->model->getBindings();
    }

    /**
     * Returns the data types of the bindings.
     *
     * @return array
     */
    public function types()
    {
        return array();
    }

    public function instance()
    {
        return $this->model;
    }
}
