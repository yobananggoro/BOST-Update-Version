<?php

namespace Modules\Opsi\Entities;

use App\Entities\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OptionGroup extends Model
{
    use SoftDeletes;
    
    /**
     * @var string
     */
    protected $table = 'mst_option_group';

    /**
     * @var array
     */
    protected $fillable = [
        'name',
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
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function optionValues()
    {
        return $this->hasMany(OptionValue::class);
    }

    /**
     * @param \Illuminate\Database\Query\Builder $query
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function scopeFetch($query, $request)
    {
        if ($request->name) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $q = $query->select(array_merge($this->fillable, ['id']))
            ->orderBy('name');

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page'));
    }
}