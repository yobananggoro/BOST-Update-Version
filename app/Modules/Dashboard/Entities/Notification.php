<?php

namespace Modules\Dashboard\Entities;

use App\Entities\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;
// use Modules\PengelolaanCSR\Entities\Pshm;
// use Modules\PengajuanCSR\Entities\Pengajuan;
// use Modules\PengajuanCSR\Entities\Realisasi;


class Notification extends Model
{
    // use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'push_notification';

    /**
     * @var array
     */
    protected $fillable = [
        'notifikasi_category', 'message',
        'is_read','receiver','sender'
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
    // public function getDescriptionForEvent(string $eventName): string
    // {
    //     return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    // }

    
    
    /**
     * @return string
     */
    // public function modelFilter()
    // {
    //     return $this->provideFilter(\Modules\PerusahaanEfek\Filters\RekeningPerusahaanEfekFilter::class);
    // }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    // public function scopeFetch($query, $request)
    // {
    //     if ($request->notifikasi_category) {
    //          $query->where('notifikasi_category', $request->periode_anggaran);
    //     }

    //     $q = $query->select(array_merge($this->fillable, ['id']))
    //         ->orderBy('notifikasi_category');

    //     if ($request->has('per_page')) {
    //         return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
    //     }

    //     return $q->paginate(config('app.display_per_page'));
    // }
}