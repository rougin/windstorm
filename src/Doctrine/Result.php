<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;
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
     * @var \Doctrine\ORM\EntityManager
     */
    protected $manager;

    /**
     * @var \Doctrine\ORM\Query\ResultSetMapping
     */
    protected $mapping;

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
     * @param  string $sql
     * @param  array  $bindings
     * @param  array  $types
     * @return mixed
     */
    public function execute($sql, array $parameters, array $types)
    {
        $connection = $this->manager->getConnection();

        if (strpos($sql, 'SELECT') === false)
        {
            return $connection->executeUpdate($sql, $parameters, $types);
        }

        $query = new NativeQuery($this->manager);

        $query->setSql($sql)->setResultSetMapping($this->mapping);

        return (array) $query->getResult();
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
