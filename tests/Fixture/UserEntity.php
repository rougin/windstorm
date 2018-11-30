<?php

namespace Rougin\Windstorm\Fixture;

/**
 * @Entity
 * @Table(name="users")
 */
class UserEntity
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

    /**
     * Initializes the entity instance.
     *
     * @param integer $id
     * @param string  $name
     */
    public function __construct($id, $name)
    {
        $this->id = (integer) $id;

        $this->name = $name;
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
}
