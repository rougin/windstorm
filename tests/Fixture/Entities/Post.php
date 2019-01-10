<?php

namespace Rougin\Windstorm\Fixture\Entities;

/**
 * @Entity
 * @Table(name="posts")
 */
class Post
{
    /**
     * @Id @GeneratedValue
     * @Column(name="id", type="integer", length=10, nullable=false, unique=false)
     * @var integer
     */
    protected $id;

    /**
     * @Column(name="title", type="string", length=200, nullable=false, unique=false)
     * @var string
     */
    protected $title;

    /**
     * @Column(name="body", type="string", length=200, nullable=false, unique=false)
     * @var string
     */
    protected $body;

    /**
     * Initializes the entity instance.
     *
     * @param integer $id
     * @param string  $title
     * @param string  $body
     */
    public function __construct($id, $title, $body)
    {
        $this->body = $body;

        $this->id = (integer) $id;

        $this->title = $title;
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
     * Returns the title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Returns the body.
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }
}
