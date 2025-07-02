<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Token extends Model
{
    /**
     * @var string
     */
    protected $table = 'mst_token';

    /**
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindToken($query, $clientId)
    {
        // dd($clientId);
        if ($clientId) {
            $query->where('clientId', 'ilike', '%' . $clientId . '%');
        }

        $q = $query->select('*')->get();
        // dd($q);

        return $q;
    }

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
}
