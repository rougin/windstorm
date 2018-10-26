<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder\Builder;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

class Query implements QueryInterface
{
    protected $alias = '';

    protected $builder;

    protected $table = '';

    public function __toString()
    {
        return $this->builder->getSql();
    }

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function select(array $fields)
    {
        $this->builder->resetQueryParts();

        $this->builder->select($fields);

        return $this;
    }

    public function from($table)
    {
        $this->alias = $this->alias($table);

        $this->table = (string) $table;

        $this->builder->from($table, $this->alias);

        return $this;
    }

    public function innerJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->alias, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->alias, $local, $alias, $foreign);

        $this->builder->innerJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function leftJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->alias, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->alias, $local, $alias, $foreign);

        $this->builder->leftJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function rightJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->alias, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->alias, $local, $alias, $foreign);

        $this->builder->rightJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function insertInto($table)
    {
        $this->builder->resetQueryParts();

        return new Insert($this, $this->builder, $table);
    }

    public function update($table)
    {
        $this->builder->resetQueryParts();

        $this->alias = $this->alias($table);

        $this->table = (string) $table;

        return new Update($this, $this->builder, $table);
    }

    public function deleteFrom($table)
    {
        $this->builder->resetQueryParts();

        $this->alias = $this->alias($table);

        $this->table = (string) $table;

        $this->builder->delete($table, $this->alias);

        return $this;
    }

    public function where($key)
    {
        return new Where($this, $this->builder, $key);
    }

    public function andWhere($key)
    {
        return new Where($this, $this->builder, $key, 'AND');
    }

    public function orWhere($key)
    {
        return new Where($this, $this->builder, $key, 'OR');
    }

    public function groupBy(array $fields)
    {
        $this->builder->groupBy($fields);

        return $this;
    }

    public function having($key)
    {
        return new Having($this, $this->builder, $key);
    }

    public function andHaving($key)
    {
        return new Having($this, $this->builder, $key, 'AND');
    }

    public function orHaving($key)
    {
        return new Having($this, $this->builder, $key, 'OR');
    }

    public function orderBy($key)
    {
        return new Order($this, $this->builder, $key);
    }

    public function andOrderBy($key)
    {
        return new Order($this, $this->builder, $key, 'AND');
    }

    public function limit($limit, $offset = null)
    {
        $this->builder->setMaxResults($limit);

        if ($offset !== null)
        {
            $this->builder->setFirstResult($offset);
        }

        return $this;
    }

    public function builder(Builder $builder)
    {
        $this->builder = $builder;

        return $this;
    }

    public function result(ResultInterface $result)
    {
        $parameters = $this->builder->getParameters();

        $sql = $this->builder->getSql();

        $types = $this->builder->getParameterTypes();

        return $result->execute($sql, $parameters, $types);
    }

    protected function alias($table)
    {
        $characters = str_split($table);

        foreach ($characters as $character)
        {
            $character = strtolower($character);

            if ($this->alias !== $character)
            {
                return $character;
            }
        }
    }
}
