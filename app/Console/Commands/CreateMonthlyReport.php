<?php

namespace App\Console\Commands;

use App\Models\ReportSupply;
use App\Services\MakeMonthlyReportService;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateMonthlyReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-monthly-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */

    protected $makeMonthlyReportService;

    public function __construct(MakeMonthlyReportService $makeMonthlyReportService)
    {
        parent::__construct();
        $this->makeMonthlyReportService = $makeMonthlyReportService;
    }

    public function handle()
    {
        $this->makeMonthlyReportService->createMonthlyReport();
        $this->info('Monthly Data Report Created');
    }
}
