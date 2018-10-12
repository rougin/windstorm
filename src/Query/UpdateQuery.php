<?php

namespace Rougin\Windstorm\Query;

class UpdateQuery extends AbstractQuery
{
    public function get()
    {
        $set = (string) ' SET ' . implode(', ', $this->parts['set']);

        return 'UPDATE ' . $this->table() . $set . $this->where();
    }
}
