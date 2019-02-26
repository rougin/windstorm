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
     * @var integer
     */
    protected $fetch = \PDO::FETCH_ASSOC;

    /**
     * @var \Doctrine\DBAL\Driver\Statement
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
        if ($query->type() !== QueryInterface::TYPE_SELECT)
        {
            $this->affected = $this->response($query);

            return $this;
        }

        $this->result = $this->response($query);

        return $this;
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        return $this->result->fetch($this->fetch);
    }

    /**
     * Returns the last inserted ID.
     *
     * @return integer
     */
    public function inserted()
    {
        return $this->connection->lastInsertId();
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        return $this->result->fetchAll($this->fetch);
    }

    /**
     * Executes the query from the connection instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Doctrine\DBAL\Driver\Statement|integer
     */
    protected function response(QueryInterface $query)
    {
        $bindings = $query->bindings();

        $sql = (string) $query->sql();

        if ($query->type() === QueryInterface::TYPE_SELECT)
        {
            return $this->connection->executeQuery($sql, $bindings);
        }

        return $this->connection->executeUpdate($sql, $bindings);
    }
}
