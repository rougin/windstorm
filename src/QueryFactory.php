<?php

namespace Rougin\Windstorm;

/**
 * Query Factory
 *
 * @method \Rougin\Windstorm\WhereInterface where($key)
 *
 * @package Windstorm
 * @author  Rougin Gutib <rougingutib@gmail.com>
 */
class QueryFactory
{
    /**
     * @var \Rougin\Windstorm\QueryInterface
     */
    protected $query;

    /**
     * @var string
     */
    protected $table = '';

    /**
     * Initializes the factory instance.
     *
     * @param \Rougin\Windstorm\QueryInterface $query
     */
    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    /**
     * Stores a newly created resource in storage.
     *
     * @param  array $data
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function create($data)
    {
        return $this->query->insertInto($this->table)->values($data);
    }

    /**
     * Deletes the specified resource from storage.
     *
     * @param  integer $id
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function delete($id)
    {
        $query = $this->query->deleteFrom($this->table);

        return $query->where('id')->equals($id);
    }

    /**
     * Finds the specified resource from storage.
     *
     * @param  integer $id
     * @param  array   $fields
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function find($id, $fields = array('*'))
    {
        $query = $this->query->select($fields)->from($this->table);

        return $query->where('id')->equals((integer) $id)->limit(1);
    }

    /**
     * Paginates the specified page number and items per page.
     *
     * @param  integer $page
     * @param  integer $limit
     * @param  array   $fields
     * @return \Rougin\Windstorm\QueryInterface
     */
    public function paginate($limit = 10, $offset = 0, $fields = array('*'))
    {
        $query = $this->query->select($fields)->from($this->table);

        return $query->limit((integer) $limit, (integer) $offset);
    }

    /**
     * Updates the specified resource in storage.
     *
     * @param  array|integer $id
     * @param  array         $data
     * @return boolean
     */
    public function update($id, array $data, $primary = 'id')
    {
        $query = $this->query->update($this->table);

        foreach ((array) $data as $key => $value)
        {
            $query = $query->set($key, $value);
        }

        return $query->where($primary)->equals($id);
    }
}
