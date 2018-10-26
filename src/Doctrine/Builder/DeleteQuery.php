<?php

namespace Rougin\Windstorm\Doctrine\Builder;

class DeleteQuery extends AbstractQuery
{
    public function get()
    {
        return 'DELETE FROM ' . $this->table() . $this->where();
    }
}
