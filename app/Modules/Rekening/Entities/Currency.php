<?php

namespace Modules\Rekening\Entities;

use App\Entities\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    // use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'mst_currency';

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

        $q = $query->select('*')
            ->orderBy('updated_at');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}