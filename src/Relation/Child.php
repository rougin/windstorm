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
    protected $column = '';

    /**
     * @var string
     */
    protected $foreign = '';

    /**
     * Initializes the child query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     * @param string                           $foreign
     * @param string                           $column
     */
    public function __construct(QueryInterface $query, $foreign, $column)
    {
        parent::__construct($query);

        $this->column = $column;

        $this->foreign = $foreign;
    }

    /**
     * Returns the identifier column for identifying children from the parent table.
     *
     * @return string
     */
    public function column()
    {
        return $this->column;
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
}
