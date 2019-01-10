<?php

namespace Rougin\Windstorm\Fixture\Mappings;

use Rougin\Windstorm\MappingInterface;
use Rougin\Windstorm\Fixture\Entities\Post;
use Rougin\Windstorm\Fixture\Entities\User;

class UserPostMapping implements MappingInterface
{
    public function map($data)
    {
        $user = new User($data['id'], $data['name']);

        $posts = array();

        foreach ($data['posts'] as $item)
        {
            $posts[] = new Post($item['id'], $item['title'], $item['body']);
        }

        return $user->setPosts($posts);
    }
}
