<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Concerns\WithValidation;
use Illuminate\Support\Collection;

class TotalImport implements ToCollection, WithHeadingRow, SkipsEmptyRows
{
    public $countRows = 0;

    public function collection(Collection $rows)
    {
        // dd($rows);
        // foreach ($rows as $key => $value) {
        //     // $val[] = $value['nominal'];
        //     // $this->sum += $value['nominal'];
        //     $val[] = $value;
            
        // }
        // dd(collect($val)->take(2)->all());
        $this->countRows += count($rows);
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function getRows()
    {
        return $this->countRows;
    }
}