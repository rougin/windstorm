<?php

namespace Rougin\Windstorm\Query;

use Rougin\Windstorm\Builder;

class QueryFactory
{
    protected $table = '';

    public function __construct(Builder $builder)
    {
        $this->builder = $builder;
    }

    public function all($offset = 10, $limit = 20, $select = '*')
    {
        $builder = $this->builder->from((string) $this->table);

        $builder = $builder->select($select)->setMaxResults($limit);

        return $builder->setFirstResult((integer) $offset);
    }

    public function create($data)
    {
        return $this->builder->insert($this->table)->values($data);
    }

    public function delete($id)
    {
        $table = $this->builder->delete((string) $this->table);

        return $table->where('id = ?')->setParameter(0, $id);
    }

    public function update($id, $data = array())
    {
        $table = $this->builder->update((string) $this->table);

        foreach ($data as $key => $value) {
            $table = $table->set((string) $key, $value);
        }

        return $table->where('id = ?')->setParameter(0, $id);
    }
}
