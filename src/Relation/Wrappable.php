<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\QueryInterface;

/**
 * Wrappable
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Wrappable implements QueryInterface
{
    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * Clones the builder instance.
     *
     * @return void
     */
    public function __clone()
    {
        $this->query = clone $this->query;
    }

    /**
     * Initializes the wrappable instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * Generates an AND HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function andHaving($key)
    {
        return $this->query->andHaving($key);
    }

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key)
    {
        return $this->query->andOrderBy($key);
    }

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key)
    {
        return $this->query->andWhere($key);
    }

    /**
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function bindings()
    {
        return $this->query->bindings();
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
        return $this->query->deleteFrom($table, $alias);
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
        return $this->query->from($table, $alias);
    }

    /**
     * Generates a GROUP BY query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function groupBy($fields)
    {
        return $this->query->groupBy($fields);
    }

    /**
     * Generates a HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function having($key)
    {
        return $this->query->having($key);
    }

    /**
     * Generates an INNER JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function innerJoin($table, $parent, $child)
    {
        return $this->query->innerJoin($table, $parent, $child);
    }

    /**
     * Generates an INSERT INTO query.
     *
     * @param  string $table
     * @return \Rougin\Windstorm\InsertInterface
     */
    public function insertInto($table)
    {
        return $this->query->insertInto($table);
    }

    /**
     * Returns the instance of the query builder, if any.
     *
     * @return mixed
     */
    public function instance()
    {
        return $this->query->instance();
    }

    /**
     * Generates a LEFT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function leftJoin($table, $parent, $child)
    {
        return $this->query->leftJoin($table, $parent, $child);
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
        return $this->query->limit($limit, $offset);
    }

    /**
     * Generates an OR HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function orHaving($key)
    {
        return $this->query->orHaving($key);
    }

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key)
    {
        return $this->query->orWhere($key);
    }

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key)
    {
        return $this->query->orderBy($key);
    }

    /**
     * Generates a RIGHT JOIN query.
     *
     * @param  string $table
     * @param  string $local
     * @param  string $foreign
     * @return self
     */
    public function rightJoin($table, $parent, $child)
    {
        return $this->query->rightJoin($table, $parent, $child);
    }

    /**
     * Generates a SELECT query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function select($fields)
    {
        return $this->query->select($fields);
    }

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function sql()
    {
        return $this->query->sql();
    }

    /**
     * Returns the table name from the query.
     *
     * @return string
     */
    public function table()
    {
        return $this->query->table();
    }

    /**
     * Returns the type of the query.
     *
     * @return integer
     */
    public function type()
    {
        return $this->query->type();
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
        return $this->query->update($table, $alias);
    }

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key)
    {
        return $this->query->where($key);
    }
}
