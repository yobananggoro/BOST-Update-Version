<?php

namespace Modules\BulkTransaksi\Entities;

use App\Entities\Model;
use Modules\User\Entities\Role;
use Illuminate\Database\Eloquent\SoftDeletes;

class BulkTrx extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'app_bulk_transaction';

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
     * @param string $eventNames
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
        if ($request->id_role) {
            $query->where('id_role', 'ilike', '%' . $request->id_role . '%');
        }

        $q = $query->select('*')
            ->orderBy('updated_at', 'desc');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }

    public function roles()
    {
        return $this->belongsTo(Role::class, 'id_role', 'id');
    } 
    
    public function roleotos()
    {
        return $this->belongsTo(Role::class, 'id_role_otorisasi', 'id');
    } 
}