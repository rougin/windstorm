<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\HavingInterface;

/**
 * Having Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Having extends Where implements HavingInterface
{
    /**
     * @var string
     */
    protected $method = 'having';
}
