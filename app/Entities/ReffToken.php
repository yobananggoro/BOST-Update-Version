<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ReffToken extends Model
{
    /**
     * @var string
     */
    protected $table = 'reference_token';

    /**
    * @var array
    */
    protected $primaryKey = 'token';
    
    
    /**
    * @var array
    */
    public $timestamps = false;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindTokenReff($query, $refToken)
    {
        $q = $query->where('token', $refToken)->get();

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
