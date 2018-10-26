<?php

namespace Rougin\Windstorm\Doctrine\Builder;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Query\Expression\ExpressionBuilder;

class Expression extends ExpressionBuilder
{
    public function __construct(Connection $connection = null)
    {
        if ($connection !== null)
        {
            $this->connection = $connection;
        }
    }
}
