<?php

namespace Modules\HakAkses\Filters;

class RoleFilter extends \EloquentFilter\ModelFilter
{
    /**
     * @param string $name
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function name($name)
    {
        // return $this->whereLike('name', $name);
        return $this->where('name', 'ilike', "%{$name}%");
    }
}
