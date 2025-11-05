<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'mst_currency';
    protected $fillable = ['curr_code', 'curr_desc', 'isactive'];
    public $timestamps = false;
}