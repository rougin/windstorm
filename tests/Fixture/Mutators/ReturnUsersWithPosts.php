<?php

namespace Rougin\Windstorm\Fixture\Mutators;

use Rougin\Windstorm\MutatorInterface;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\Relation\Child;
use Rougin\Windstorm\Relation\Mixed;

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
        $fields = 'u.id as u_id, u.name as u_name';
        $users = clone $query;
        $users->select($fields)->from('users', 'u');

        $fields = 'p.id as p_id, p.title as p_title, ';
        $fields .= 'p.body as p_body, p.user_id as p_user_id';
        $posts = clone $query;
        $posts->select($fields)->from('posts', 'p');

        $mixed = new Mixed($users, 'u_id');
        $child = new Child($posts, 'p_user_id', 'p.user_id');

        return $mixed->add($child, 'u_posts');
    }
}
