<?php

namespace Rougin\Windstorm;

/**
 * Where Interface
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
interface WhereInterface
{
    /**
     * Generates an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function equals($value);

    /**
     * Generates an non-equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notEqualTo($value);

    /**
     * Generates a greater-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThan($value);

    /**
     * Generates a greater-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function greaterThanOrEqualTo($value);

    /**
     * Generates an IN () query comparison.
     *
     * @param  array $values
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function in(array $values);

    /**
     * Generates an NOT IN () query comparison.
     *
     * @param  array $values
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notIn(array $values);

    /**
     * Generates a false comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isFalse();

    /**
     * Generates an IS NOT NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNotNull();

    /**
     * Generates an IS NULL query comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isNull();

    /**
     * Generates a true comparison.
     *
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function isTrue();

    /**
     * Generates a less-than comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThan($value);

    /**
     * Generates a less-than or an equality comparison.
     *
     * @param  mixed $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function lessThanOrEqualTo($value);

    /**
     * Generates a LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function like($value);

    /**
     * Generates a NOT LIKE query comparison.
     *
     * @param  string $value
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function notLike($value);
}
