<?php

namespace Modules\Rekening\Entities;

use App\Entities\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rekening extends Model
{
    // use SoftDeletes;
    
    /**
    * @var string
    */
    protected $table = 'mst_rekening';
    
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
        if ($request->nama) {
            $query->where('nama', 'ilike', '%' . $request->nama . '%');
        }
        
        if ($request->cif) {
            $query->where('cif', 'ilike', '%' . $request->cif . '%');
        }
        
        $q = $query->select('*')
        ->orderBy('updated_at');
        
        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }
        
        return $q->paginate(config('app.display_per_page'));
    }
    
    public function scopeList($query, $request)
    {
        if ($request->nama) {
            $query->where('nama', 'ilike', '%' . $request->nama . '%');
        }
        
        if ($request->cif) {
            $query->where('cif', 'ilike', '%' . $request->cif . '%');
        }
        
        if(auth()->user()->profile->rolename == "SUPER ADMIN"){
            $q = $query->select('*')
            ->orderBy('updated_at');
        } else {
            $q = $query->select('*')
            // ->where('branch', '=', auth()->user()->profile->unit_kerja_kode)
            ->orderBy('updated_at');
        }
        
        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }
        
        return $q->paginate(config('app.display_per_page'));
    }
}