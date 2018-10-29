<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
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
     * @var \Rougin\Windstorm\Doctrine\Builder
     */
    protected $builder;

    /**
     * @var \Rougin\Windstorm\Doctrine\Expression
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
     * @param \Rougin\Windstorm\Doctrine\Query   $query
     * @param \Rougin\Windstorm\Doctrine\Builder $builder
     * @param string                             $key
     * @param string                             $type
     */
    public function __construct(Query $query, Builder $builder, $key, $type = '')
    {
        $this->builder = $builder;

        $this->expression = new Expression;

        $this->query = $query;

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->eq($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->neq($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->gt($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->gte($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        foreach (array_values($values) as $key => $value)
        {
            $this->builder->setParameter($index + $key, $value, gettype($value));
        }

        $new = str_repeat('? ', count($values));

        $new = (array) explode(' ', trim($new));

        $expr = $this->expression->in($this->key, $new);

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        foreach (array_values($values) as $key => $value)
        {
            $this->builder->setParameter($index + $key, $value, gettype($value));
        }

        $new = str_repeat('? ', count($values));

        $new = (array) explode(' ', trim($new));

        $expr = $this->expression->notIn($this->key, $new);

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
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->isNull($this->key);

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
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->eq($this->key, 1);

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->lt($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->lte($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->like($this->key, '?');

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
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value, gettype($value));

        $expr = $this->expression->notLike($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }
}
