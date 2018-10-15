<?php

namespace Rougin\Windstorm\Result;

use Illuminate\Database\Connection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class EloquentResult implements ResultInterface
{
    protected $connection;

    protected $model;

    public function execute($sql, array $parameters, array $types)
    {
        $type = strtolower(substr($sql, 0, 6));

        $result = $this->connection->$type($sql, $parameters);

        foreach ($result as $index => $item)
        {
            $current = $this->model;

            $item = (array) $item;

            foreach ($item as $key => $value)
            {
                $current->setAttribute($key, $value);
            }

            $result[$index] = $current;
        }

        return new Collection((array) $result);
    }

    public function model(Model $model, $connection = null)
    {
        $this->model = $model;

        $this->connection = $model->getConnection($connection);
    }
}
