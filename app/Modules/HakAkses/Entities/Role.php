<?php

namespace Modules\HakAkses\Entities;

use App\Concerns\TapActivity;
use EloquentFilter\Filterable;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\DB;
use Spatie\Activitylog\LogOptions;

class Role extends \Spatie\Permission\Models\Role
{
    use Filterable, TapActivity;

    /**
     * @var string
     */
    protected $roleHasModule = 'mst_role_has_module';

    /**
     * @var bool
     */
    protected static $logFillable = true;

    /**
     * @param string $eventName
     * @return string
     */
    public function getDescriptionForEvent(string $eventName): string
    {
        return get_class() . ' ' . json_encode($this->attributesToArray()) . ' ' . $eventName . '.';
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable() // Mencatat log untuk semua kolom di $fillable
            ->logOnlyDirty() // Hanya mencatat jika ada perubahan data
            ->dontSubmitEmptyLogs(); // Menghindari log kosong
    }

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\HakAkses\Filters\RoleFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function modules(): BelongsToMany
    {
        return $this->belongsToMany(\App\Entities\Module::class, $this->roleHasModule)
            ->orderByRaw('cast(sequence as float)');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function scopeFetch($query, $perPage)
    {
        $user = auth()->user();
        if (!$user || !method_exists($user, 'hasRole') || !call_user_func([$user, 'hasRole'], 'SUPER ADMIN')) {
            $query->where('id', '<>', 99);
        }

        $q = $query->select(['id', 'name'])
            ->orderBy('id');

        if (!is_null($perPage)) {
            return $perPage === 'All' ? $q->get() : $q->paginate($perPage);
        }

        return $q->paginate(config('app.display_per_page'));
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return int
     */
    public function scopeGetNewId($query): int
    {
        $result = $query->select('id')->orderByDesc('id')->first();

        return ($result) ? $result->id + 1 : 99;
    }

    /**
     * @param int $id
     * @param array $modules
     */
    public static function syncModules(int $id, array $modules): void
    {
        $roleHasModuleTable = (new static)->roleHasModule;
        DB::table($roleHasModuleTable)->where('role_id', $id)->delete();
        collect($modules)->each(function ($item, $key) use ($id, $roleHasModuleTable) {
            DB::table($roleHasModuleTable)->insert(['role_id' => $id, 'module_id' => $item]);
        });
    }
}
