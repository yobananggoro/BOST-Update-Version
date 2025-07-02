<?php

namespace Modules\Log\Entities;

use EloquentFilter\Filterable;

class LogActivity extends \Spatie\Activitylog\Models\Activity
{
    use Filterable;

    /**
     * @return string
     */
    public function modelFilter()
    {
        return $this->provideFilter(\Modules\Log\Filters\LogActivityFilter::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(\Modules\User\Entities\User::class, 'causer_id')
            ->join('app_profile', 'app_user.id', '=', 'app_profile.user_id');
    }

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|null $perPage
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function scopeFetch($query, $perPage)
    {
        $q = $query->select([
            'id', 'log_name', 'description', 'causer_id', 'properties', 'ip_address', 'user_agent', 'created_at'
        ])->orderBy('created_at', 'desc');

        if (!is_null($perPage))
            return $perPage === 'All' ? $q->get() : $q->paginate($perPage);

        return $q->paginate(config('app.display_per_page'));
    }
}