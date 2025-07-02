<?php

namespace App\Entities;

use Illuminate\Support\Facades\DB;

class Alasan extends Model
{
    /**
     * @var string
     */
    protected $table = 'app_alasan';

    /**
     * @var array
     */
    protected $fillable = [
        'record_id', 'proses', 'tanggal', 'alasan', 'user_id',
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
