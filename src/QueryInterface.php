<?php

namespace Rougin\Windstorm;

/**
 * Query Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface QueryInterface
{
    const TYPE_SELECT = 0;

    const TYPE_INSERT = 1;

    const TYPE_UPDATE = 2;

    const TYPE_DELETE = 3;

    /**
     * Generates a SELECT query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function select($fields);

    /**
     * Generates a FROM query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function from($table, $alias = null);

    /**
     * Generates an INNER JOIN query.
     *
     * @param  string      $table
     * @param  string      $local
     * @param  string      $foreign
     * @param  string|null $alias
     * @return self
     */
    public function innerJoin($table, $local, $foreign, $alias = null);

    /**
     * Generates a LEFT JOIN query.
     *
     * @param  string      $table
     * @param  string      $local
     * @param  string      $foreign
     * @param  string|null $alias
     * @return self
     */
    public function leftJoin($table, $local, $foreign, $alias = null);

    /**
     * Generates a RIGHT JOIN query.
     *
     * @param  string      $table
     * @param  string      $local
     * @param  string      $foreign
     * @param  string|null $alias
     * @return self
     */
    public function rightJoin($table, $local, $foreign, $alias = null);

    /**
     * Generates an INSERT INTO query.
     *
     * @param  string $table
     * @return \Rougin\Windstorm\InsertInterface
     */
    public function insertInto($table);

    /**
     * Generates an UPDATE query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return \Rougin\Windstorm\UpdateInterface
     */
    public function update($table, $alias = null);

    /**
     * Generates a DELETE FROM query.
     *
     * @param  string      $table
     * @param  string|null $alias
     * @return self
     */
    public function deleteFrom($table, $alias = null);

    /**
     * Generates a WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function where($key);

    /**
     * Generates an AND WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function andWhere($key);

    /**
     * Generates an OR WHERE query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\WhereInterface
     */
    public function orWhere($key);

    /**
     * Generates a GROUP BY query.
     *
     * @param  array|string $fields
     * @return self
     */
    public function groupBy($fields);

    /**
     * Generates a HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function having($key);

    /**
     * Generates an AND HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function andHaving($key);

    /**
     * Generates an OR HAVING query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\HavingInterface
     */
    public function orHaving($key);

    /**
     * Generates an ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function orderBy($key);

    /**
     * Generates a multiple ORDER BY query.
     *
     * @param  string $key
     * @return \Rougin\Windstorm\OrderInterface
     */
    public function andOrderBy($key);

    /**
     * Performs a LIMIT query.
     *
     * @param  integer      $limit
     * @param  integer|null $offset
     * @return self
     */
    public function limit($limit, $offset = null);

    /**
     * Returns the SQL bindings specified.
     *
     * @return array
     */
    public function bindings();

    /**
     * Returns the instance of the query builder, if any.
     *
     * @return mixed
     */
    public function instance();

    /**
     * Returns the safe and compiled SQL.
     *
     * @return string
     */
    public function sql();

    /**
     * Returns the table name from the query.
     *
     * @return string
     */
    public function table();

    /**
     * Returns the type of the query.
     *
     * @return integer
     */
    public function type();
}
