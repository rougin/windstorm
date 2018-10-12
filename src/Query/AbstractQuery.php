<?php

namespace Rougin\Windstorm\Query;

abstract class AbstractQuery
{
    protected $parts = array();

    public function __construct(array $parts)
    {
        $this->parts = $parts;
    }

    protected function table()
    {
        $table = $this->parts['from']['table'];

        $alias = null;

        if (isset($this->parts['from']['alias'])) {
            $alias = $this->parts['from']['alias'];
        }

        return $table . ($alias ? ' ' . $alias : '');
    }

    protected function where()
    {
        $where = (string) $this->parts['where'];

        return $where !== null ? ' WHERE ' . $where : '';
    }
}
