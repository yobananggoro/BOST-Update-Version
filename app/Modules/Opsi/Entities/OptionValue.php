<?php

namespace Modules\Opsi\Entities;

use App\Entities\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionValue extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'mst_option_value';

    /**
     * @var array
     */
    protected $fillable = [
        'option_group_id', 'key', 'value', 'sequence',
    ];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
}