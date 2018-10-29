<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\ResultInterface;

class Query implements QueryInterface
{
    protected $builder;

    protected $initial = '';

    protected $table = '';

    public function __toString()
    {
        return $this->sql();
    }

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function select(array $fields)
    {
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        $this->builder->select($fields);

        return $this;
    }

    public function from($table, $alias = null)
    {
        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = $table;

        $this->builder->from($table, $alias);

        return $this;
    }

    public function innerJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->innerJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function leftJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->leftJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function rightJoin($table, $local, $foreign)
    {
        $alias = $this->alias((string) $table);

        list($current, $condition) = array($this->initial, '%s.%s = %s.%s');

        $condition = sprintf($condition, $this->initial, $local, $alias, $foreign);

        $this->builder->rightJoin($current, $table, $alias, $condition);

        return $this;
    }

    public function insertInto($table, $alias = null)
    {
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        return new Insert($this, $this->builder, $table, $alias);
    }

    public function update($table, $alias = null)
    {
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = $table;

        return new Update($this, $this->builder, $table, $alias);
    }

    public function deleteFrom($table, $alias = null)
    {
        $this->builder->resetQueryParts();

        $this->builder->setParameters(array());

        if ($alias === null)
        {
            $alias = $table[0];
        }

        $this->initial = $alias;

        $this->table = (string) $table;

        $this->builder->delete($table, $alias);

        return $this;
    }

    public function where($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key);
    }

    public function andWhere($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key, 'AND');
    }

    public function orWhere($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Where($this, $this->builder, $key, 'OR');
    }

    public function groupBy(array $fields)
    {
        foreach ($fields as $key => $field)
        {
            if (strpos($field, '.') === false)
            {
                $fields[$key] = $this->initial . '.' . $field;
            }
        }

        $this->builder->groupBy($fields);

        return $this;
    }

    public function having($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key);
    }

    public function andHaving($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key, 'AND');
    }

    public function orHaving($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Having($this, $this->builder, $key, 'OR');
    }

    public function orderBy($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Order($this, $this->builder, $key);
    }

    public function andOrderBy($key)
    {
        if (strpos($key, '.') === false)
        {
            $key = $this->initial . '.' . $key;
        }

        return new Order($this, $this->builder, $key, 'ADD');
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

    public function sql()
    {
        return $this->builder->getSql();
    }

    public function bindings()
    {
        return $this->builder->getParameters();
    }

    public function types()
    {
        return $this->builder->getParameterTypes();
    }

    protected function alias($table)
    {
        $characters = str_split($table);

        $result = $characters[0];

        foreach ($characters as $character)
        {
            $character = strtolower($character);

            if ($this->initial !== $character)
            {
                $result = $character; break;
            }
        }

        return (string) $result;
    }
}
