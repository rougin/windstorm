<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\ChildInterface;
use Rougin\Windstorm\QueryInterface;

/**
 * Child
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Child extends Wrappable implements ChildInterface
{
    /**
     * @var string
     */
    protected $field = '';

    /**
     * @var string
     */
    protected $foreign = '';

    /**
     * @var string
     */
    protected $primary = '';

    /**
     * Initializes the child query instance.
     *
     * @param string                           $field
     * @param \Rougin\Windstorm\QueryInterface $query
     * @param string                           $primary
     * @param string                           $foreign
     */
    public function __construct($field, QueryInterface $query, $primary, $foreign)
    {
        parent::__construct($query);

        $this->field = $field;

        $this->foreign = $foreign;

        $this->primary = $primary;
    }

    /**
     * Returns the field to store the result from the
     * child query instance and append it to the result
     * from the parent query instance as a single value.
     *
     * @return string
     */
    public function field()
    {
        return $this->field;
    }

    /**
     * Returns the identifier column from the child table.
     *
     * @return string
     */
    public function foreign()
    {
        return $this->foreign;
    }

    /**
     * Returns the identifier column from the parent table.
     *
     * @return string
     */
    public function primary()
    {
        return $this->primary;
    }

    /**
     * Returns the specified query instance.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function query()
    {
        return $this->query;
    }
}
