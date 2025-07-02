<?php

namespace Modules\User\Entities;

use App\Concerns\TapActivity;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use TapActivity;

    /**
     * @var string
     */
    protected $table = 'app_profile';

    /**
     * @var bool
     */
    protected $primaryKey = 'user_id';

    /**
     * @var bool
     */
    // public $incrementing = false;

    /**
     * @var array
     */
    protected $fillable = [
        'nama', 'nip', 'hp', 'unit_kerja_kode', 'rolename', 'idrole', 'limit_kredit', 'limit_debet', 'isFinger', 'jabatan'
    ];

    /**
     * @var bool
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

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function scopeFetch($query, $request)
    {
        $q = $query->select('*')
            ->orderBy('updated_at', 'desc');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function unitKerja()
    {
        return $this->belongsTo(\App\Entities\UnitKerja::class);
    }
}