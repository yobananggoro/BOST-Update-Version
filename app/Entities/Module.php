<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Module extends Model
{
    /**
     * @var string
     */
    protected $table = 'mst_module';

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByLabel($query, $value)
    {
        // dd($value);
        return $query->where('label', $value)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopePermissions($query)
    {
        return $query->select([
            'id', 'label', 'uri', 'parent_module as parent_id', 'sequence',
            DB::raw("case when parent_module is null then '' else (select x.label from " . $this->table . " x where x.id = " . $this->table . ".parent_module) end as parent_module")
        ])
        ->orderByRaw("string_to_array(sequence, '.')::int[]")
        ->get();
    }
}
