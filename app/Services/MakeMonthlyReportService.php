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
        // Create a writer (you can use 'Xlsx' for .xlsx format or 'Xls' for .xls format)
        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');

        // Specify the path where you want to save the file
        $savePath = storage_path('app/public/rsmi.xlsx');

        // Save the file
        $writer->save($savePath);

        // Optionally, return the saved file path or send it as a download response
        return $savePath;
    }
}
