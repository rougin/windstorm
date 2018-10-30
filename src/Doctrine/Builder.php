<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Windstorm\Doctrine\Builder\DeleteQuery;
use Rougin\Windstorm\Doctrine\Builder\InsertQuery;
use Rougin\Windstorm\Doctrine\Builder\SelectQuery;
use Rougin\Windstorm\Doctrine\Builder\UpdateQuery;

/**
 * Query Builder
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Builder extends QueryBuilder
{
    /**
     * @var \Doctrine\DBAL\Platforms\AbstractPlatform
     */
    protected $platform;

    /**
     * Initializes the platform instance.
     *
     * @param \Doctrine\DBAL\Connection|\Doctrine\DBAL\Platforms\AbstractPlatform $platform
     */
    public function __construct($platform)
    {
        if ($platform instanceof Connection)
        {
            $platform = $platform->getDatabasePlatform();
        }

        $this->platform = $platform;
    }

    /**
     * Returns the complete SQL string.
     *
     * @return string
     */
    public function getSql()
    {
        $first = $this->getFirstResult();

        $max = $this->getMaxResults();

        $parts = $this->getQueryParts();

        switch ($this->getType())
        {
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
            default:
                $sql = new SelectQuery($parts, $this->platform, $max, $first);

                break;
        }

        return (string) $sql->get();
    }
}
