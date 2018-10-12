<?php

namespace Rougin\Windstorm;

interface OrmInterface
{
    public function execute($sql, array $parameters, array $types);
}
