<?php

namespace App\Entities;

class UnitKerja extends Model
{
    /**
    * @var string
    */
    protected $table = 'app_unit_kerja';
    
    /**
    * @var string
    */
    protected $primaryKey = 'kode';
    
    /**
    * @var array
    */
    protected $fillable = [
        // 'kode', 'nama', 'parentkode', 'hckode', 'cabang', 'kanwil',
        'kode', 'nama', 'kode_induk'
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
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Collection
    */
    // public function scopeCabangPerKanwil($query)
    // {
    //     $kanwil = [];
    //     $cabang = [];
    //     $results = $query->where('cabang', 't')
    //     ->orderBy('kanwil')
    //     ->orderBy('kode')
    //     ->get();
        
    //     foreach ($results as $result) {
    //         $key = to_lower(str_replace(' ', '', $result->kanwil));
    //         $kanwil[$key] = $result->kanwil;
    //         $cabang[$key][] = [
    //             'kode' => $result->kode,
    //             'nama' => $result->nama,
    //             'kanwil' => $result->kanwil,
    //         ];
    //     }
        
    //     return collect(['kanwil' => $kanwil, 'cabang' => $cabang]);
    // }
    
    public function scopeGetAll($query)
    {
        $q = $query->select('*')->orderBy('kode', 'asc')->get();
        
        return $q;
    }
    
    public function transactions()
    {
        return $this->belongsTo(Transactions::class);
    }
}