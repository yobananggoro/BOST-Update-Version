<?php

namespace Modules\User\Entities; 

use App\Concerns\TapActivity;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use CanResetPassword, HasRoles, Notifiable, TapActivity;

    /**
     * @var string
     */
    protected $table = 'app_user';

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
        'username', 'password', 'email', 'status', 'isLogin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

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

    public function scopeGetAll($query)
    {
        // dd(auth()->user()->profile->idrole, auth()->user());exit;
        if (!in_array(auth()->user()->profile->rolename, ['SUPER ADMIN', 'Staf ITS ', 'Staf IT'])) {
            $q = $query->select('app_user.*','app_profile.*')
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
            ->where('app_profile.unit_kerja_kode', '=', auth()->user()->profile->unit_kerja_kode)
            ->where('app_user.username', '!=', auth()->user()->username)
            ->whereIn('app_profile.rolename', ['Administrasi Dana Dan Jasa', 'Administrasi Kredit', 'Administrasi Operasional', 'Staff'])
            ->orderby('app_user.status', 'desc');
        } else {
            $q = $query->select('app_user.*','app_profile.*')
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
            ->where('app_user.username', '!=', auth()->user()->username)
            ->where('app_profile.rolename', '!=', 'SUPER ADMIN')
            ->orderby('app_user.status', 'desc');
        }
        
        return $q->get();
    }
    
    public function scopeRetrive($query)
    {
        $q = $query->select('app_user.*','app_profile.*')
        ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
        ->orderby('status', 'desc');
        
        return $q->get();
    }

    public function scopeFetch($query, $request)
    {
        if ($request->userID) {
            $query->where('username', 'ilike', '%' . $request->userID . '%');
        }
        
        $q = $query->select('app_user.*','mst_model_has_role.role_id','mst_role.name')
        ->join('mst_model_has_role', 'app_user.id', '=', 'mst_model_has_role.model_uuid')
        ->join('mst_role', 'mst_model_has_role.role_id', '=', 'mst_role.id')
        ->orderBy('username');
        
        if ($request->has('per_page')) {
            return $request->per_page === 'All' ? $q->get() : $q->paginate($request->per_page);
        }

        return $q->paginate(config('app.display_per_page')); 
    }

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function profile()
    {
        return $this->hasOne(Profile::class)
        ->select(['app_profile.*', 'mst_role.is_transactions'])
        ->join('mst_role', 'mst_role.id', '=', 'app_profile.idrole');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByUsername($query, $value)
    {
        return $query->where('username', $value)->first();
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $value
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function scopeFindByRoleId($query, $request)
    {
        $q = $query->select(['app_user.*', 'app_profile.*'])
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id')
            ->join('mst_model_has_role', 'app_user.id', '=', 'mst_model_has_role.model_uuid');
        
        if (is_array($request)) {
            return $q->whereIn('mst_model_has_role.role_id', $request)->get();
        } else {
            return $q->where('mst_model_has_role.role_id', $request)->get();
        }
    }
}
