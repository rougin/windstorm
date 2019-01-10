<?php

namespace Rougin\Windstorm\Relation;

use Rougin\Windstorm\YoungsterInterface;
use Rougin\Windstorm\QueryInterface;

/**
 * Youngster
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Youngster extends Wrappable implements YoungsterInterface
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
    protected $local = '';

    /**
     * Initializes the child query instance.
     *
     * @param string                           $field
     * @param \Rougin\Windstorm\QueryInterface $query
     * @param string                           $local
     * @param string                           $foreign
     */
    public function __construct($field, QueryInterface $query, $local, $foreign)
    {
        parent::__construct($query);

        $this->field = $field;

        $this->foreign = $foreign;

        $this->local = $local;
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
    public function local()
    {
        return $this->local;
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
