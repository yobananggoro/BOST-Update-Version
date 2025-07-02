<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Collection;

class TotalImport implements ToCollection, WithHeadingRow
{
    public $countRows = 0;

    public function collection(Collection $rows)
    {
        // dd(count($rows));
        // foreach ($rows as $key => $value) {
        //     // $val[] = $value['nominal'];
        //     $this->sum += $value['nominal'];
        // }
        $this->countRows += count($rows);
    }

    public function getRows()
    {
        return $this->countRows;
    }
}