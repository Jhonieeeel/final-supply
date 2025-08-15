<?php

namespace App\Imports;

use App\Models\ReportSupply;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;

class ReportImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        dd($row);

        return new ReportSupply();
    }

    public function collection(Collection $rows)
    {
        dd($rows);
    }
}
