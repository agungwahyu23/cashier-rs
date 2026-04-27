<?php

namespace App\Console\Commands;

use App\Services\TransactionReportService;
use Illuminate\Console\Command;

class SendTransactionReport extends Command
{
    protected $signature = 'report:transactions';
    protected $description = 'Send daily transaction report';

    protected $service;

    public function __construct(TransactionReportService $service)
    {
        parent::__construct();
        $this->service = $service;
    }

    public function handle()
    {
        $this->service->sendDailyReport();

        $this->info('Report sent successfully!');
    }
}