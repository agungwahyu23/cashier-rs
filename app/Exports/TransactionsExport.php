<?php

namespace App\Exports;

use App\Models\Transaction;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class TransactionsExport implements FromCollection, WithHeadings
{
    protected $date;

    public function __construct($date)
    {
        $this->date = $date;
    }

    public function collection()
    {
        return Transaction::with('details')
            ->whereDate('created_at', $this->date)
            ->get()
            ->map(function ($trx) {
                return [
                    'Kode Transaksi' => $trx->invoice_number,
                    'Tanggal' => $trx->created_at,
                    'Total' => $trx->grand_total,
                    'Status' => $trx->status,
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Kode Transaksi',
            'Tanggal',
            'Total',
            'Status',
        ];
    }
}