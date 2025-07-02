<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Log extends Model
{
    /**
     * @var string
     */
    protected $table = 'transactions_log';

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
        'id',
    ];

    /**
     * @var boolean
     */
    public $timestamps = false;

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
}
