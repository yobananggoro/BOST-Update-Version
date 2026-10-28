<?php

namespace App\Entities;

use App\Concerns\TapActivity;
use Spatie\Activitylog\LogOptions;

class Model extends \Illuminate\Database\Eloquent\Model
{
    use TapActivity;

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $incrementing = false;

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = (string) \Illuminate\Support\Str::uuid();
        });
    }

    // Tambahkan fungsi wajib Laravel Activitylog v4 ini:
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logAll() // Mengisi log untuk semua perubahan field
            ->logOnlyDirty(); // Hanya mencatat field yang benar-benar berubah nilainya
    }
}
