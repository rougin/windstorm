<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder;
use Rougin\Windstorm\Doctrine\Builder\Expression;
use Rougin\Windstorm\WhereInterface;

class Where implements WhereInterface
{
    protected $builder;

    protected $expression;

    protected $key;

    protected $method = 'where';

    protected $query;

    protected $type;

    public function __construct(Query $query, Builder $builder, $key, $type = '')
    {
        $this->builder = $builder;

        $this->expression = new Expression;

        $this->query = $query;

        $this->key = $key;

        $this->type = $type;
    }

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

    public function isFalse()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->eq($this->key, 0);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function isNotNull()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->isNotNull($this->key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function isNull()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->isNull($this->key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function isTrue()
    {
        $type = strtolower($this->type) . $this->method;

        $expr = $this->expression->eq($this->key, 1);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

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
