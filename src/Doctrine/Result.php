<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Driver\PDOStatement;
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

    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    public function first()
    {
        if ($this->data instanceof PDOStatement)
        {
            return $this->data->fetch($this->type);
        }

        return current($this->data);
    }

    public function items()
    {
        if ($this->data instanceof PDOStatement)
        {
            return $this->data->fetchAll($this->type);
        }

        return $this->data;
    }
}
