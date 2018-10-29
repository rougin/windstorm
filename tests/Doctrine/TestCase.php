<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Doctrine\DBAL\Platforms\MySqlPlatform;

abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $platform = new MySqlPlatform;

        $this->builder = new Builder($platform);
    }
}
