<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Doctrine\DBAL\Platforms\MySqlPlatform;

/**
 * Test Case
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
abstract class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * Sets up the query builder instance.
     *
     * @return void
     */
    public function setUp()
    {
        $builder = new Builder(new MySqlPlatform);

        $this->query = new Query($builder);
    }
}
