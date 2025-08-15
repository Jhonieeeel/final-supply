<?php

namespace App\Livewire\Pages\Afms;

use App\Services\MakeMonthlyReportService;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;


class RsmiTable extends Component
{

    use WithFileUploads;

    public $rsmiFile;

    public function create()
    {
        $report = new MakeMonthlyReportService();
        $sheet = $report->createMonthlyReport($this->rsmiFile);

        $sheet->setCellValue('B14', 'RIS_TEST');
        $sheet->setCellValue('C14', 'RIS_TEST');
        $sheet->setCellValue('D14', 'Stock No. Test');
        $sheet->setCellValue('E14', 'Alcohol 500ml');
        $sheet->setCellValue('F14', 'Bottle');
        $sheet->setCellValue('G14', '2');

        $report->saveReport($report->getSpreadsheet());
    }

    #[Layout('layouts.app')]
    public function render()
    {
        return view('livewire.pages.afms.rsmi-table');
    }
}
