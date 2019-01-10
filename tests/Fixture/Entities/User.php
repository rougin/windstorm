<?php

namespace Rougin\Windstorm\Fixture\Entities;

/**
 * @Entity
 * @Table(name="users")
 */
class User
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=false, unique=false)
     * @var integer
     */
    protected $id;

    /**
     * @Column(name="name", type="string", length=200, nullable=false, unique=false)
     * @var string
     */
    protected $name;

    protected $posts = array();

    /**
     * Initializes the entity instance.
     *
     * @param integer                                   $id
     * @param string                                    $name
     * @param \Rougin\Windstorm\Fixture\Entities\Post[] $posts
     */
    public function __construct($id, $name, array $posts = array())
    {
        $this->id = (integer) $id;

        $this->name = $name;

        $this->posts = $posts;
    }

    /**
     * Returns the ID.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Returns the name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Returns the posts.
     *
     * @return string
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Returns the post instances.
     *
     * @param  \Rougin\Windstorm\Fixture\Entities\Post[] $posts
     * @return self
     */
    public function setPosts(array $posts)
    {
        $this->posts = $posts;

        return $this;
    }
}
