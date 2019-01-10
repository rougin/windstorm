<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\MutatorInterface;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\Relation\OneToMany;

/**
 * Return Users With Posts Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnUsersWithPosts implements MutatorInterface
{
    public function set(QueryInterface $query)
    {
        $relation = new OneToMany($query);

        $relation->local('users');
        $relation->field(0, 'id');
        $relation->field(0, 'name');

        $relation->foreign('posts');
        $relation->field(1, 'id');
        $relation->field(1, 'title');
        $relation->field(1, 'body');

        $relation->column('posts');

        return $relation->make('id', 'user_id');
    }
}
