<?php

namespace Rougin\Windstorm\Mutators;

use Rougin\Windstorm\QueryInterface;
use Rougin\Windstorm\MutatorInterface;

/**
 * Return Entities Mutator
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class ReturnEntities implements MutatorInterface
{
    /**
     * @var string
     */
    protected $alias = '';

    /**
     * @var string[]
     */
    protected $fields = array('*');

    /**
     * @var integer|null
     */
    protected $limit = 10;

    /**
     * @var integer|null
     */
    protected $offset = 0;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * @var array
     */
    protected $wheres = array();

    /**
     * Initializes the mutator instance.
     *
     * @param integer|null $limit
     * @param integer|null $offset
     */
    public function __construct($limit = null, $offset = null)
    {
        $this->limit = $limit;

        $this->offset = $offset;
    }

    /**
     * Returns an array of specified fields.
     *
     * @return array
     */
    public function fields()
    {
        return $this->fields;
    }

    /**
     * Returns the limit per result.
     *
     * @return integer
     */
    public function limit()
    {
        return $this->limit;
    }

    /**
     * Returns the offset of the current result.
     *
     * @return integer
     */
    public function offset()
    {
        return $this->offset;
    }

    /**
     * Mutates the specified query instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function set(QueryInterface $query)
    {
        if (! $this->alias && $this->table)
        {
            $this->alias = $this->table[0];
        }

        $query = $this->query($query);

        $multiple = false;

        $operations = array('<>', '>=', '<=', '>', '<', '=');

        foreach ($this->wheres as $key => $value)
        {
            $method = $multiple ? 'andWhere' : 'where';

            $text = str_replace($operations, '', $value);

            $operator = str_replace($text, '', $value);

            switch ($operator)
            {
                case '<':
                    $query->{$method}($key)->lessThan($text);

                    break;
                case '<=':
                    $query->{$method}($key)->lessThanOrEqualTo($text);

                    break;
                case '<>':
                    $query->{$method}($key)->notEqualTo($text);

                    break;
                case '>':
                    $query->{$method}($key)->greaterThan($text);

                    break;
                case '>=':
                    $query->{$method}($key)->greaterThanOrEqualTo($text);

                    break;
                default:
                    if (strpos($value, '%') === false)
                    {
                        $query->{$method}($key)->equals($value);

                        break;
                    }

                    $query->{$method}($key)->like($value);

                    break;
            }

            $multiple = true;
        }

        if ($this->limit === null)
        {
            return $query;
        }

        return $query->limit($this->limit, $this->offset);
    }

    /**
     * Sets a where like instance to the query.
     *
     * @param  string $key
     * @param  mixed  $value
     * @return self
     */
    public function where($key, $value)
    {
        $this->wheres[$key] = $value;

        return $this;
    }

    /**
     * Sets an array of where like conditions.
     *
     * @param  array $wheres
     * @return self
     */
    public function wheres(array $wheres)
    {
        foreach ($wheres as $key => $value)
        {
            $this->where($key, $value);
        }

        return $this;
    }

    /**
     * Sets a predefined query instance.
     *
     * @param  \Rougin\Windstorm\QueryInterface $query
     * @return \Rougin\Windstorm\QueryInterface
     */
    protected function query(QueryInterface $query)
    {
        $query->select((array) $this->fields);

        return $query->from($this->table, $this->alias);
    }
}
