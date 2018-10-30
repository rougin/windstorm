<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Rougin\Windstorm\ResultInterface;

/**
 * Result
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Result implements ResultInterface
{
    /**
     * @var \Illuminate\Database\Connection
     */
    protected $connection;

    /**
     * @var \Illuminate\Database\Eloquent\Model
     */
    protected $model;

    /**
     * Executes an SQL statement with its bindings and types.
     *
     * @param  string $sql
     * @param  array  $bindings
     * @param  array  $types
     * @return mixed
     */
    public function execute($sql, array $parameters, array $types)
    {
        $connection = $this->model->getConnection();

        $type = (string) strtolower(substr($sql, 0, 6));

        $result = $connection->$type($sql, $parameters);

        if (is_array($result) === false)
        {
            return $result;
        }

        return $this->model->hydrate($result);
    }

    /**
     * Sets the Eloquent model to be used.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return self
     */
    public function model(Model $model)
    {
        $this->model = $model;
    }
}
