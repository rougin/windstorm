<?php

namespace Rougin\Windstorm\Fixture;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\QueryRepository;
use Rougin\Windstorm\ResultInterface;

/**
 * User Repository
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class UserRepository extends QueryRepository
{
    /**
     * Initializes the repository instance.
     *
     * @param \Rougin\Windstorm\QueryInterface  $query
     * @param \Rougin\Windstorm\ResultInterface $result
     */
    public function __construct(QueryInterface $query, ResultInterface $result)
    {
        parent::__construct($query, $result);

        $this->mapper(new UserMapper);
    }
}
