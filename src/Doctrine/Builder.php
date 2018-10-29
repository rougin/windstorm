<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Windstorm\Doctrine\Builder\DeleteQuery;
use Rougin\Windstorm\Doctrine\Builder\InsertQuery;
use Rougin\Windstorm\Doctrine\Builder\SelectQuery;
use Rougin\Windstorm\Doctrine\Builder\UpdateQuery;

class Builder extends QueryBuilder
{
    public function __construct($platform)
    {
        if ($platform instanceof Connection)
        {
            $this->connection = $platform;

            $platform = $platform->getDatabasePlatform();
        }

        $this->platform = $platform;
    }

    public function getSql()
    {
        $first = $this->getFirstResult();

        $max = $this->getMaxResults();

        $parts = $this->getQueryParts();

        switch ($this->getType()) {
            case self::INSERT:
                $sql = new InsertQuery($parts);

                break;
            case self::DELETE:
                $sql = new DeleteQuery($parts);

                break;
            case self::UPDATE:
                $sql = new UpdateQuery($parts);

                break;
            case self::SELECT:
                $sql = new SelectQuery($parts, $this->platform, $max, $first);

                break;
        }

        return (string) $sql->get();
    }

    public function set($key, $value)
    {
        $parameters = $this->getParameters();

        $index = count((array) $parameters);

        $this->setParameter($index, $value);

        return $this->add('set', $key . ' = ?', true);
    }

    public function values(array $values)
    {
        $index = 0;

        foreach ($values as $key => $value)
        {
            $this->setParameter($index, $value);

            $index = $index + 1;

            $values[$key] = '?';
        }

        return $this->add('values', $values);
    }
}
