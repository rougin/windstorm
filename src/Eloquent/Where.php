<?php

namespace Rougin\Windstorm\Eloquent;

use Illuminate\Database\Eloquent\Builder;
use Rougin\Windstorm\WhereInterface;

class Where implements WhereInterface
{
    protected $builder;

    protected $method = 'where';

    protected $query;

    protected $key;

    protected $type;

    public function __construct(Query $query, Builder $builder, $key, $type = 'and')
    {
        $this->query = $query;

        $this->builder = $builder;

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
        return $this->where('=', $value);
    }

    /**
     * Generates an non-equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notEqualTo($value)
    {
        return $this->where('!=', $value);
    }

    /**
     * Generates a greater-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThan($value)
    {
        return $this->where('>', $value);
    }

    /**
     * Generates a greater-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThanOrEqualTo($value)
    {
        return $this->where('>=', $value);
    }

    /**
     * Generates an IN () query comparison.
     *
     * @param  array $values
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function in(array $values)
    {
        $this->builder = $this->builder->whereIn($this->key, $values, $this->type);

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
        $this->builder = $this->builder->whereNotIn($this->key, $values, $this->type);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a false comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isFalse()
    {
        return $this->where('=', false);
    }

    /**
     * Generates an IS NOT NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNotNull()
    {
        $this->builder = $this->builder->whereNotNull($this->key, $this->type);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates an IS NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNull()
    {
        $this->builder = $this->builder->whereNull($this->key, $this->type);

        return $this->query->builder($this->builder);
    }

    /**
     * Generates a true comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isTrue()
    {
        return $this->where('=', true);
    }

    /**
     * Generates a less-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThan($value)
    {
        return $this->where('<', true);
    }

    /**
     * Generates a less-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThanOrEqualTo($value)
    {
        return $this->where('<=', true);
    }

    /**
     * Generates a LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function like($value)
    {
        return $this->where('like', $value);
    }

    /**
     * Generates a NOT LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notLike($value)
    {
        return $this->where('not like', $value);
    }

    /**
     * Sets the query builder instance.
     *
     * @param  string $operator
     * @param  mixed  $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    protected function where($operator, $value)
    {
        $method = (string) $this->method;

        $this->builder = $this->builder->$method($this->key, $operator, $value, $this->type);

        return $this->query->builder($this->builder);
    }
}
