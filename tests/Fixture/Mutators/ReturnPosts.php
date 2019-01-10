<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\MutatorInterface;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\Relation\OneToOne;

/**
 * Return Posts Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnPosts implements MutatorInterface
{
    public function set(QueryInterface $query)
    {
        $relation = new OneToOne($query);

        $posts = array('id', 'title', 'body');

        $relation->local('posts');
        $relation->fields(0, $posts);

        $users = array('id', 'name');

        $relation->foreign('users');
        $relation->fields(1, $users);

        echo $relation->make('user_id', 'id');exit;

        return $relation->make('user_id', 'id');
    }
}
