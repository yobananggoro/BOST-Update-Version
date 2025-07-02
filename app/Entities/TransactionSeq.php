<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionSeq extends Model
{
    /**
     * @var string
     */
    protected $table = 'app_transaction_seq';

    /**
     * @var array
     */
    protected $fillable = ['*'];

    /**
     * @var array
     */
    protected $hidden = [
        'id',
    ];
    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindSequence($query)
    {
        // dd($value);
        $q = $query->select('sequence')->where('userid', '=', auth()->user()->username)->orderby('sequence', 'desc')->get();

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
