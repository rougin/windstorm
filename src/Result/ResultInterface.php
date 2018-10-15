<?php

namespace Rougin\Windstorm\Result;

interface ResultInterface
{
    public function execute($sql, array $parameters, array $types);
}
