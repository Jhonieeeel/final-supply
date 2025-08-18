<?php

namespace App\Livewire\Pages\Afms;

use App\Models\ReportSupply;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;


class RsmiTable extends Component
{
    public $rsmiFile;
    public $inputtedDate;

    public function create()
    {
        dd($this->inputtedDate);
        $this->rsmiFile = storage_path("app/public/rsmi_template.xls");

        // $report = new MakeMonthlyReportService();
        // $sheet = $report->createMonthlyReport($this->rsmiFile);

        // B5 = January or From December to January
        // I7 = Supply-1-2025-01 (RSMI Serial) = Division Acronym - Year - Month - RSMI Serial Number
        // B13 = RIS_VALUE
        // D13 = Stock_Number
        // E13 = Item name
        // F13 = unit
        // G13 = Requested Qty
        // D27 = Beginning Balance
        // D30 = Total
        // D31 = Less issuance
        // D32 = Balance

        // $sheet->setCellValue('B14', 'RIS_TEST');

        // $report->saveReport($report->getSpreadsheet());
        $requisitions = ReportSupply::whereHas('requisition', function ($query) {
            $query->whereMonth('created_at', Carbon::now()->month)
                ->whereYear('created_at', Carbon::now()->year);
        })->get();

        dd($requisitions);
    }

    #[Layout('layouts.app')]
    public function render()
    {

        return view('livewire.pages.afms.rsmi-table');
    }
}
