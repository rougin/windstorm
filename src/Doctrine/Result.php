<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\ResultInterface;

/**
 * Result
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Result implements ResultInterface
{
    protected $data;

    protected $type = \PDO::FETCH_ASSOC;

    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Returns a number of affected rows.
     *
     * @return integer
     */
    public function affected()
    {
        return $this->data;
    }

    /**
     * Sets the fetch type for PDO.
     *
     * @param  integer $type
     * @return self
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Returns the first row from result.
     *
     * @return mixed
     */
    public function first()
    {
        if ($this->data instanceof \PDOStatement)
        {
            return $this->data->fetch($this->type);
        }

        return current($this->data);
    }

    /**
     * Returns all items from the result.
     *
     * @return mixed
     */
    public function items()
    {
        if ($this->data instanceof \PDOStatement)
        {
            return $this->data->fetchAll($this->type);
        }

        return $this->data;
    }
}
