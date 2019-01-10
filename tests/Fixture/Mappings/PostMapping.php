<?php

namespace Rougin\Windstorm\Fixture\Mappings;

use Rougin\Windstorm\Fixture\Entities\Post;
use Rougin\Windstorm\MappingInterface;

/**
 * Post Mapping
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class PostMapping implements MappingInterface
{
    /**
     * Maps the result data into a class.
     *
     * @param  mixed $data
     * @return mixed
     */
    public function map($data)
    {
        return new Post($data['id'], $data['title'], $data['body']);
    }
}
