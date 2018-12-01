<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Connection;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

/**
 * Result
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Result implements ResultInterface
{
    /**
     * @var integer
     */
    protected $affected = 0;

    /**
     * @var \Doctrine\DBAL\Connection
     */
    protected $connection;

    /**
     * @var \PDOStatement
     */
    protected $result;

    /**
     * Initializes the result instance.
     *
     * @param \Doctrine\DBAL\Connection $connection
     */
    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected()
    {
        return $this->affected;
    }

    /**
     * Returns a result from a query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return self
     */
    public function execute(QueryInterface $query)
    {
        $bindings = $query->bindings();

        $sql = $query->sql();

        $types = (array) $query->types();

        $connection = $this->connection;

        if (strpos($sql, 'SELECT') === false)
        {
            $this->affected = $connection->executeUpdate($sql, $bindings, $types);
        }
        else
        {
            $this->result = $connection->executeQuery($sql, $bindings, $types);
        }

        return $this;
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->result->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        return $this->result->fetchAll(\PDO::FETCH_ASSOC);
    }
}
