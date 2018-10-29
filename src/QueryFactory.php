<?php

namespace Rougin\Windstorm;

class QueryFactory
{
    protected $query;

    protected $table = '';

    public function __construct(QueryInterface $query)
    {
        $this->query = $query;
    }

    public function create($data)
    {
        return $this->query->insertInto($this->table)->values($data);
    }

    public function delete($id, $primary = 'id')
    {
        $query = $this->query->deleteFrom($this->table);

        return $query->where($primary)->equals($id);
    }

    public function find($id, $fields = array('*'))
    {
        $query = $this->query->select($fields)->from($this->table);

        return $query->where('id')->equals((integer) $id)->limit(1);
    }

    public function paginate($limit = 10, $offset = 0, $fields = array('*'))
    {
        $query = $this->query->select($fields)->from($this->table);

        return $query->limit((integer) $limit, (integer) $offset);
    }

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
