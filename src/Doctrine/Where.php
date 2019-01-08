<?php

namespace Rougin\Windstorm\Doctrine;

use Doctrine\DBAL\Query\QueryBuilder;
use Rougin\Windstorm\Doctrine\Builder\Expression;
use Rougin\Windstorm\WhereInterface;

/**
 * Where Query
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class Where implements WhereInterface
{
    /**
     * @var \Doctrine\DBAL\Query\QueryBuilder
     */
    protected $builder;

    /**
     * @var \Rougin\Windstorm\Doctrine\Builder\Expression
     */
    protected $expression;

    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $method = 'where';

    /**
     * @var \Rougin\Windstorm\Doctrine\Query
     */
    protected $query;

    /**
     * @var string
     */
    protected $type;

    /**
     * Initializes the query instance.
     *
     * @param \Rougin\Windstorm\Doctrine\Query  $query
     * @param \Doctrine\DBAL\Query\QueryBuilder $builder
     * @param string                            $key
     * @param string|null                       $initial
     * @param string                            $type
     */
    public function __construct(Query $query, QueryBuilder $builder, $key, $initial, $type = '')
    {
        $this->builder = $builder;

        $this->expression = new Expression;

        $this->query = $query;

        if ($initial && strpos($key, '.') === false)
        {
            $key = $initial . '.' . $key;
        }

        $this->key = $key;

        $this->type = $type;
    }

    /**
     * Generates an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function equals($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->eq($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an non-equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notEqualTo($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->neq($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a greater-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThan($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->gt($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a greater-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThanOrEqualTo($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->gte($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an IN () query comparison.
     *
     * @param  array $values
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function in(array $values)
    {
        list($keys, $type) = $this->parameters($values);

        $expr = $this->expression->in($this->key, $keys);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an NOT IN () query comparison.
     *
     * @param  array $values
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notIn(array $values)
    {
        list($keys, $type) = $this->parameters($values);

        $expr = $this->expression->notIn($this->key, $keys);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a false comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isFalse()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->eq($this->key, 0);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an IS NOT NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNotNull()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->isNotNull($this->key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an IS NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNull()
    {
        $expr = $this->expression->isNull($this->key);

        $type = strtolower($this->type) . $this->method;

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a true comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isTrue()
    {
        $expr = $this->expression->eq($this->key, 1);

        $type = strtolower($this->type) . $this->method;

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a less-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThan($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->lt($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a less-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThanOrEqualTo($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->lte($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function like($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->like($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a NOT LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notLike($value)
    {
        list($key, $type) = $this->parameter($value);

        $expr = $this->expression->notLike($this->key, $key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    /**
     * Sets a parameter placeholder in the builder.
     *
     * @param  mixed       $value
     * @param  string|null $suffix
     * @return array
     */
    protected function parameter($value, $suffix = null)
    {
        $key = $this->key[0] === ':' ? $this->key : ':' . $this->key;

        $key = $suffix !== null ? $key . '_' . $suffix : $key;

        $key = strtolower(str_replace('.', '_', (string) $key));

        $this->builder->setParameter($key, $value, gettype($value));

        return array($key, strtolower($this->type) . $this->method);
    }

    /**
     * Sets an array of parameter placeholders in the builder.
     *
     * @param  array $values
     * @return array
     */
    protected function parameters(array $values)
    {
        list($keys, $type) = array(array(), '');

        $values = array_values((array) $values);

        foreach ($values as $index => $value)
        {
            list($key, $type) = $this->parameter($value, $index);

            array_push($keys, $key);
        }

        return array((array) $keys, (string) $type);
    }
}
