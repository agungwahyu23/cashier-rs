<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;

class TransactionReportMail extends Mailable
{
    public $filePath;

    public function __construct($filePath)
    {
        $this->filePath = $filePath;
    }

    public function build()
    {
        return $this->subject('Laporan Transaksi Harian')
            ->view('emails.transaction_report')
            ->attach($this->filePath);
    }
}
