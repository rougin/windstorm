<?php

namespace Rougin\Windstorm\Result;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NativeQuery;
use Doctrine\ORM\Query\ResultSetMapping;

class DoctrineResult implements ResultInterface
{
    protected $manager;

    protected $mapping;

    public function __construct(EntityManager $manager)
    {
        $this->manager = $manager;
    }

    public function execute($sql, array $parameters, array $types)
    {
        $connection = $this->manager->getConnection();

        $forbidden = array('DELETE', 'INSERT', 'UPDATE');

        foreach ($forbidden as $item)
        {
            if (strpos($sql, $item) !== false)
            {
                return $connection->executeUpdate($sql, $parameters, $type);
            }
        }

        $query = new NativeQuery($this->manager);

        $query->setSql($sql)->setResultSetMapping($this->mapping);

        return (array) $query->getResult();
    }

    public function mapping(ResultSetMapping $mapping)
    {
        $this->mapping = $mapping;

        return $this;
    }
}
