<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class ConfigurationLocal extends Model
{
    /**
     * @var string
     */
    protected $table = 'mst_configuration_local';

    /**
     * @var string
     */
    protected $primaryKey = 'key';

    /**
     * @var string
     */
    protected $keyType = 'string';

    /**
     * @var bool
     */
    public $timestamps = false;

    /**
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|array $role
     * @return array
     */
    public function scopeGetUserSetting($query, $role)
    {
        $settings = [];
        $q = $query->select(['key', 'value', 'shortdesc', 'component'])
            ->where('user_config', 't')
            ->orderBy('component')
            ->orderBy('sequence');

        if (app()->environment() === 'production') {
            $q->whereNotIn('key', ['force_local', 'bypass_cutoff']);
        }

        if (in_array('CHECKER_TRISURI', $role)) {
            $q->where('show_to_user', 't');
        }

        $rows = $q->get();

        foreach ($rows as $row) {
            $settings[$row->component][] = [
                'key' => $row->key,
                'value' => $row->value,
                'shortdesc' => $row->shortdesc,
            ];
        }

        return $settings;
    }
}
