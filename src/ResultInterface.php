<?php

namespace Rougin\Windstorm;

interface ResultInterface
{
    public function execute($sql, array $parameters, array $types);
}
