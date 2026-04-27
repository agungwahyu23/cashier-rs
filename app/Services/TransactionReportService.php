<?php
namespace App\Services;

use App\Exports\TransactionsExport;
use App\Mail\TransactionReportMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class TransactionReportService
{
    public function sendDailyReport()
    {
        $yesterday = now()->subDay()->toDateString();

        $fileName = 'transaction-report-' . $yesterday . '.xlsx';

        Excel::store(new TransactionsExport($yesterday), $fileName);

        $filePath = Storage::path($fileName);

        if (!file_exists($filePath)) {
            throw new \Exception('File tidak ditemukan: ' . $filePath);
        }

        Mail::to('interview.deltasurya@yopmail.com')
            ->send(new TransactionReportMail($filePath));

        Storage::delete($fileName);
    }
}