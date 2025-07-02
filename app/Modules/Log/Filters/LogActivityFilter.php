<?php

namespace Modules\Log\Filters;

class LogActivityFilter extends \EloquentFilter\ModelFilter
{
    /**
     * @param string $causerId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function causerId($causerId)
    {
        return $this->where('causer_id', $causerId);
    }

    /**
     * @param array $tanggal
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function tanggal($tanggal)
    {
        if (!is_null($tanggal['tgl_awal']) && !is_null($tanggal['tgl_akhir'])) {
            return $this->whereBetween('created_at', [$tanggal['tgl_awal'], $tanggal['tgl_akhir']]);
        }

        if (!is_null($tanggal['tgl_awal']) && is_null($tanggal['tgl_akhir'])) {
            return $this->whereDate('created_at', $tanggal['tgl_awal']);
        }

        if (is_null($tanggal['tgl_awal']) && !is_null($tanggal['tgl_akhir'])) {
            return $this->whereDate('created_at', $tanggal['tgl_akhir']);
        }
    }
}
