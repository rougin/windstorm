<?php

namespace Rougin\Windstorm\Query;

class DeleteQuery extends AbstractQuery
{
    public function get()
    {
        return 'DELETE FROM ' . $this->table() . $this->where();
    }
}
