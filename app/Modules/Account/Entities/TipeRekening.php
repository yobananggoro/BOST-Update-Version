<?php

namespace Modules\Account\Entities;

use App\Entities\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class TipeRekening extends Model
{
    // use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'mst_acctype';

    /**
     * @var array
     */
    protected $fillable = [
        '*'
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id'
    ];

    /**
     * @param string $eventNames
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
}