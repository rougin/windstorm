<?php

namespace Rougin\Windstorm;

interface QueryInterface
{
    public function select(array $fields);

    public function from($table, $alias = null);

    public function innerJoin($table, $local, $foreign);

    public function leftJoin($table, $local, $foreign);

    public function rightJoin($table, $local, $foreign);

    public function insertInto($table);

    public function update($table, $alias = null);

    public function deleteFrom($table, $alias = null);

    public function where($key);

    public function andWhere($key);

    public function orWhere($key);

    public function groupBy(array $fields);

    public function having($key);

    public function andHaving($key);

    public function orHaving($key);

    public function orderBy($key);

    public function sql();

    public function bindings();

    public function types();
}
