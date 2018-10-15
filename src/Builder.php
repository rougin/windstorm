<?php

namespace Rougin\Windstorm;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Windstorm\Query\DeleteQuery;
use Rougin\Windstorm\Query\InsertQuery;
use Rougin\Windstorm\Query\ResultQuery;
use Rougin\Windstorm\Query\SelectQuery;
use Rougin\Windstorm\Query\UpdateQuery;
use Rougin\Windstorm\Result\ResultInterface;

class Builder extends QueryBuilder
{
    public function __construct($platform)
    {
        if ($platform instanceof Connection) {
            $platform = $platform->getDatabasePlatform();
        }

        $this->platform = $platform;
    }

    public function getSql()
    {
        $parts = $this->getQueryParts();

        $max = $this->getMaxResults();

        $first = $this->getFirstResult();

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

    public function result(ResultInterface $result)
    {
        $parameters = (array) $this->getParameters();

        $sql = (string) $this->getSql();

        $types = (array) $this->getParameterTypes();

        return $result->execute($sql, $parameters, $types);
    }
}
