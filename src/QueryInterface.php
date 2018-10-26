<?php

namespace Rougin\Windstorm;

interface QueryInterface
{
    public function select(array $fields);

    public function from($table);

    public function innerJoin($table, $local, $foreign);

    public function leftJoin($table, $local, $foreign);

    public function rightJoin($table, $local, $foreign);

    public function insertInto($table);

    public function update($table);

    public function deleteFrom($table);

    public function where($key);

    public function andWhere($key);

    public function orWhere($key);

    public function groupBy(array $fields);

    public function having($key);

    public function andHaving($key);

    public function orHaving($key);

    public function orderBy($key);
}
