<?php

namespace Modules\User\Entities;

use App\Concerns\TapActivity;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\LogOptions;

class Role extends Model
{
    use TapActivity;

    /**
     * @var string
     */
    protected $table = 'mst_role';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        '*'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * @var bool
     */
    protected static $logFillable = true;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Mencatat log untuk semua kolom di $fillable
            ->logOnlyDirty() // Hanya mencatat jika ada perubahan data
            ->dontSubmitEmptyLogs(); // Menghindari log kosong
    }

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
}
