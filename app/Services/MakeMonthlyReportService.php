<?php

namespace App\Services;

use PhpOffice\PhpSpreadsheet\IOFactory;

class MakeMonthlyReportService
{
    protected $spreadsheet;

    public function createMonthlyReport($excelFile)
    {
        $this->spreadsheet = IOFactory::load($excelFile->getRealPath());

        return $this->spreadsheet->getActiveSheet();
    }

    public function getSpreadsheet()
    {
        return $this->spreadsheet;
    }

    public function saveReport($spreadsheet)
    {
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        $savePath = storage_path('app/public/rsmi.xlsx');

        $writer->save($savePath);

        return $savePath;
    }
}
