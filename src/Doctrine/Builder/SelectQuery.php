<?php

namespace Rougin\Windstorm\Doctrine\Builder;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Query\QueryException;

/**
 * Select Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class SelectQuery
{
    /**
     * @var array
     */
    protected $parts = array();

    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected $platform;

    /**
     * @var integer|null
     */
    protected $max = null;

    /**
     * @var integer|null
     */
    protected $first = null;

    /**
     * Initializes the query instance.
     *
     * @param array                                     $parts
     * @param \Doctrine\DBAL\Platforms\AbstractPlatform $platform
     * @param integer|null                              $max
     * @param integer|null                              $first
     */
    public function __construct($parts, AbstractPlatform $platform, $max, $first)
    {
        $this->parts = $parts;

        $this->platform = $platform;

        $this->max = $max;

        $this->first = $first;
    }

    /**
     * Returns the compiled SQL.
     *
     * @return string
     */
    public function get()
    {
        $query = 'SELECT ' . (string) implode(', ', (array) $this->parts['select']);

        $query .= $this->parts['from'] ? ' FROM ' . (string) implode(', ', $this->clauses()) : '';

        $query .= $this->parts['where'] !== null ? ' WHERE ' . $this->parts['where'] : '';

        $query .= $this->parts['groupBy'] ? ' GROUP BY ' . implode(', ', $this->parts['groupBy']) : '';

        $query .= $this->parts['having'] !== null ? ' HAVING ' . $this->parts['having'] : '';

        $query .= $this->parts['orderBy'] ? ' ORDER BY ' . implode(', ', $this->parts['orderBy']) : '';

        if ($this->max !== null || $this->first !== null)
        {
            return $this->platform->modifyLimitQuery($query, $this->max, $this->first);
        }

        return $query;
    }

    /**
     * Verifies and returns the clauses specified.
     *
     * @return string[]
     */
    protected function clauses()
    {
        list($aliases, $clauses) = array(array(), array());

        // Loop through all FROM clauses
        foreach ($this->parts['from'] as $from)
        {
            $sql = $reference = $from['table'];

            if ($from['alias'] !== null)
            {
                $sql = $from['table'] . ' ' . $from['alias'];

                $reference = (string) $from['alias'];
            }

            $aliases[$reference] = true;

            $clauses[$reference] = $sql . $this->joins($reference, $aliases);
        }

        $this->verify($aliases);

        return $clauses;
    }

    /**
     * Creates JOIN queries on specified tables.
     *
     * @param  string $alias
     * @param  array  $aliases
     * @return string
     * @throws \Doctrine\DBAL\Query\QueryException
     */
    protected function joins($alias, array &$aliases)
    {
        $sql = '';

        if (! isset($this->parts['join'][$alias]))
        {
            return $sql;
        }

        foreach ($this->parts['join'][$alias] as $join)
        {
            if (array_key_exists($join['joinAlias'], $aliases))
            {
                throw QueryException::nonUniqueAlias($join['joinAlias'], array_keys($aliases));
            }

            $sql .= ' ' . strtoupper($join['joinType']) . ' JOIN ' . $join['joinTable'];

            $sql .= ' ' . $join['joinAlias'] . ' ON ' . ((string) $join['joinCondition']);

            $aliases[$join['joinAlias']] = true;
        }

        foreach ($this->parts['join'][$alias] as $join)
        {
            $sql .= $this->joins($join['joinAlias'], $aliases);
        }

        return $sql;
    }

    /**
     * Verifies the specified aliases.
     *
     * @param  array $aliases
     * @throws \Doctrine\DBAL\Query\QueryException
     */
    protected function verify(array $aliases)
    {
        foreach ($this->parts['join'] as $alias => $joins)
        {
            if (! isset($aliases[$alias]))
            {
                throw QueryException::unknownAlias($alias, array_keys($aliases));
            }
        }
    }
}
