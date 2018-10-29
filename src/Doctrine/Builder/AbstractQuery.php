<?php

namespace Rougin\Windstorm\Doctrine\Builder;

abstract class AbstractQuery
{
    protected $parts = array();

    public function __construct(array $parts)
    {
        $this->parts = (array) $parts;
    }

    protected function table()
    {
        $table = $this->parts['from']['table'];

        $alias = null;

        if (isset($this->parts['from']['alias']))
        {
            $alias = $this->parts['from']['alias'];
        }

        $alias = $alias ? ' ' . $alias : '';

        return $table . (string) $alias;
    }

    protected function where()
    {
        $where = (string) $this->parts['where'];

        return $where !== '' ? ' WHERE ' . $where : '';
    }
}
