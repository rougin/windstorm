<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Connection;
use Rougin\Windstorm\CompositeInterface;
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
     * @var \Rougin\Windstorm\CompositeInterface|null
     */
    protected $composite = null;

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

        if ($query instanceof CompositeInterface)
        {
            $this->composite = $query;
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
        $result = $this->result->fetch($this->fetch);

        if ($this->composite)
        {
            $items = array($result);

            $items = $this->composite($items);

            return current($items);
        }

        return $result;
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        $items = $this->result->fetchAll($this->fetch);

        if ($this->composite)
        {
            return $this->composite($items);
        }

        return $items;
    }

    /**
     * Appends children output to original result.
     *
     * @param  array $items
     * @param  array $result
     * @param  string $local
     * @param  string $foreign
     * @param  string $field
     * @return array
     */
    protected function append($items, $result, $local, $foreign, $field)
    {
        foreach ($items as $key => $item)
        {
            $items[$key][$field] = array();

            foreach ($result as $child)
            {
                if ($child[$foreign] === $item[$local])
                {
                    $items[$key][$field][] = $child;
                }
            }
        }

        return $items;
    }

    /**
     * Appends result from composite query to main result.
     *
     * @param  array $items
     * @return array
     */
    protected function composite($items)
    {
        foreach ($this->composite->children() as $child)
        {
            $foreign = $child->foreign();

            $field = $child->field();

            $local = $child->local();

            $ids = $this->identities($items, $local);

            $stmt = $this->response($child->query()->where($foreign)->in($ids));

            $result = $stmt->fetchAll($this->fetch);

            $items = $this->append($items, $result, $local, $foreign, $field);
        }

        return $items;
    }

    /**
     * Returns the values based of specified key.
     *
     * @param  string $items
     * @param  string $key
     * @return array
     */
    protected function identities($items, $key)
    {
        $ids = array();

        foreach ($items as $item)
        {
            $ids[] = $item[$key];
        }

        return $ids;
    }

    /**
     * Executes the query from the connection instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Doctrine\DBAL\Driver\Statement|null
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
