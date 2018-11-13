<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
use Rougin\Windstorm\ExecuteInterface;
use Rougin\Windstorm\QueryInterface;

/**
 * Execute
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Execute implements ExecuteInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\Query\ResultSetMapping|null
     */
    protected $mapping = null;

    /**
     * Initializes the entity manager instance.
     *
     * @param \Doctrine\ORM\EntityManager $manager
     */
    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Returns the entity manager instance.
     *
     * @return \Doctrine\ORM\EntityManager
     */
    public function manager()
    {
        return $this->manager;
    }

    /**
     * Executes an SQL statement with its bindings and types.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\ResultInterface
     */
    public function execute(QueryInterface $query)
    {
        $bindings = $query->bindings();

        $sql = $query->sql();

        $types = (array) $query->types();

        $connection = $this->manager->getConnection();

        if (strpos($sql, 'SELECT') === false)
        {
            return new Result($connection->executeUpdate($sql, $bindings, $types));
        }

        if ($this->mapping === null)
        {
            return new Result($connection->executeQuery($sql, $bindings, $types));
        }

        $query = new NativeQuery($this->manager);

        $query->setSql($sql)->setResultSetMapping($this->mapping);

        foreach ($bindings as $key => $binding)
        {
            $query->setParameter($key, $binding, $types[$key]);
        }

        return new Result((array) $query->getResult());
    }

    /**
     * Sets the result set mapping instance.
     *
     * @param  \Doctrine\ORM\Query\ResultSetMapping $mapping
     * @return self
     */
    public function mapping(ResultSetMapping $mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }
}
