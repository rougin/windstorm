<?php

namespace Rougin\Windstorm\Doctrine\Builder;

/**
 * Abstract Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class AbstractQuery
{
    /**
     * @var array
     */
    protected $parts = array();

    /**
     * Initializes the query instance.
     *
     * @param array $parts
     */
    public function __construct(array $parts)
    {
        $this->parts = (array) $parts;
    }

    /**
     * Returns the table name with a specified alias.
     *
     * @return string
     */
    protected function table()
    {
        $table = $this->parts['from']['table'];

        $alias = null;

        if (isset($this->parts['from']['alias']))
        {
            $alias = $this->parts['from']['alias'];
        }

        $alias = $alias ? ' ' . $alias : '';

        return $table . (string) $alias;
    }

    /**
     * Returns the parameters for the WHERE clause.
     *
     * @return string
     */
    protected function where()
    {
        $where = (string) $this->parts['where'];

        return $where !== '' ? ' WHERE ' . $where : '';
    }
}
