<?php

namespace Rougin\Windstorm\Doctrine;

use Rougin\Windstorm\Doctrine\Builder\Builder;
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

    public function greaterThan($value)
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->gt($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function greaterThanOrEqualTo($value)
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->gte($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function lessThan($value)
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->lt($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function lessThanOrEqualTo($value)
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->lte($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function equals($value)
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->eq($this->key, '?');

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

    public function isNotNull()
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, $value);

        $expr = $this->expression->isNotNull($this->key);

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function isTrue()
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, true);

        $expr = $this->expression->eq($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }

    public function isFalse()
    {
        $type = strtolower($this->type) . $this->method;

        $parameters = $this->builder->getParameters();

        $index = count((array) $parameters);

        $this->builder->setParameter($index, false);

        $expr = $this->expression->eq($this->key, '?');

        $this->builder->$type($expr);

        return $this->query->builder($this->builder);
    }
}
