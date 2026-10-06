<?php

namespace Modules\Pemindahbukuan\Entities;

use App\Entities\Model;
use Carbon\Carbon;

class Transactions extends Model
{
    /**
    * @var string
    */
    protected $table = 'app_transaction';
    
    /**
    * @var array
    */
    protected $fillable = ['*'];
    
    /**
    * @var array
    */
    protected $hidden = [
        'id', 'reff'
    ];
    
    /**
    * @param string $eventName
    * @return string
    */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }
    
    public function scopeFetch($query, $request)
    {
        if ($request->status_override) {
            $query->where('status_override', '=', $request->status_override);
        }
        if ($request->status_validasi_posting) {
            $query->where('status_transaksi', '=', $request->status_validasi_posting);
        } 
        if ($request->tipe_transaksi) {
            $query->where('tipe_transaksi', '=', $request->tipe_transaksi);
        } 
        if ($request->userid) {
            $query->where('userid', '=', $request->userid);
        }
        if ($request->reff) {
            $query->where('reff', '=', $request->reff);
        }
        if ($request->branch) {
            $query->where('branch', '=', $request->branch);
        }
        
        if(in_array(auth()->user()->profile->rolename, ["Operator"])){ 
            $q = $query->select('*')
            ->where('userid', auth()->user()->username)
            // ->where('tanggal', Carbon::now()->format('Y-m-d'))
            ->orderBy('updated_at', 'desc');
        } else if(!in_array(auth()->user()->profile->rolename,["Operator","SUPER ADMIN"])){
            // dd('a');
            $q = $query->select('*')
            ->where('branch', auth()->user()->profile->unit_kerja_kode)
            // ->where('tanggal', Carbon::now()->format('Y-m-d'))
            ->orderBy('updated_at', 'desc');
        } else{
            // dd('b');
            $q = $query->select('*')
            ->orderBy('updated_at', 'desc');
        }

        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }
        
        return $q->paginate(config('app.display_per_page'));
    }

    public function scopeOtoremote($query, $request)
    {
        if ($request->tipe_transaksi) {
            $query->where('tipe_transaksi', '=', $request->tipe_transaksi);
        }
        if ($request->userid) {
            $query->where('userid', '=', $request->userid);
        }
        if ($request->reff) {
            $query->where('reff', '=', $request->reff);
        }
        
        if(auth()->user()->profile->rolename != "SUPER ADMIN"){
            $q = $query->select('*')
            ->where('branch', auth()->user()->profile->unit_kerja_kode)
            ->where('status_override', 1)
            ->where('tanggal', Carbon::now()->format('Y-m-d'))
            ->orderBy('updated_at', 'desc');
        } else{
            $q = $query->select('*')
            ->where('status_override', 1)
            // ->where('tanggal', Carbon::now()->format('Y-m-d'))
            ->orderBy('updated_at', 'desc');
        }

        $q = $query->select('*')->where('status_override', 1)
        ->orderBy('updated_at', 'desc');
        
        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }
        
        return $q->paginate(config('app.display_per_page'));
    }

    public function unitKerja()
    {
        return $this->belongsTo(\App\Entities\UnitKerja::class, 'branch', 'kode');
    }
}
