<?php

namespace Rougin\Windstorm\Query;

use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Query\QueryException;

class SelectQuery
{
    protected $parts = array();

    protected $platform;

    protected $max = null;

    protected $first = null;

    public function __construct($parts, AbstractPlatform $platform, $max, $first)
    {
        $this->parts = $parts;

        $this->platform = $platform;

        $this->max = $max;

        $this->first = $first;
    }

    public function get()
    {
        $query = 'SELECT ' . (string) implode(', ', $this->parts['select']);

        $query .= $this->parts['from'] ? ' FROM ' . (string) implode(', ', $this->clauses()) : '';
        $query .= $this->parts['where'] !== null ? ' WHERE ' . ((string) $this->parts['where']) : '';
        $query .= $this->parts['groupBy'] ? ' GROUP BY ' . implode(', ', $this->parts['groupBy']) : '';
        $query .= $this->parts['having'] !== null ? ' HAVING ' . ((string) $this->parts['having']) : '';
        $query .= $this->parts['orderBy'] ? ' ORDER BY ' . implode(', ', $this->parts['orderBy']) : '';

        if ($this->max !== null || $this->first !== null) {
            return $this->platform->modifyLimitQuery($query, $this->max, $this->first);
        }

        return $query;
    }

    /**
     * @return string[]
     */
    protected function clauses()
    {
        $clauses = array();

        $aliases = array();

        // Loop through all FROM clauses
        foreach ($this->parts['from'] as $from) {
            if ($from['alias'] === null) {
                $sql = $from['table'];

                $reference = $from['table'];
            } else {
                $sql = $from['table'] . ' ' . $from['alias'];

                $reference = $from['alias'];
            }

            $aliases[$reference] = true;

            $clauses[$reference] = $sql . $this->joins($reference, $aliases);
        }

        $this->verify($aliases);

        return $clauses;
    }

    /**
     * @param string $alias
     * @param array  $aliases
     *
     * @return string
     *
     * @throws QueryException
     */
    protected function joins($alias, array &$aliases)
    {
        $sql = '';

        if (! isset($this->parts['join'][$alias])) {
            return $sql;
        }

        foreach ($this->parts['join'][$alias] as $join) {
            if (array_key_exists($join['joinAlias'], $aliases)) {
                throw QueryException::nonUniqueAlias($join['joinAlias'], array_keys($aliases));
            }

            $sql .= ' ' . strtoupper($join['joinType']) . ' JOIN ' . $join['joinTable'];
            $sql .= ' ' . $join['joinAlias'] . ' ON ' . ((string) $join['joinCondition']);

            $aliases[$join['joinAlias']] = true;
        }

        foreach ($this->parts['join'][$alias] as $join) {
            $sql .= $this->joins($join['joinAlias'], $aliases);
        }

        return $sql;
    }

    /**
     * @param array $aliases
     *
     * @throws QueryException
     */
    protected function verify(array $aliases)
    {
        foreach ($this->parts['join'] as $alias => $joins) {
            if ( ! isset($aliases[$alias])) {
                throw QueryException::unknownAlias($alias, array_keys($aliases));
            }
        }
    }
}
