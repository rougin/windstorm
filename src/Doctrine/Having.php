<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\HavingInterface;

class Having extends Where implements HavingInterface
{
    protected $method = 'having';
}
