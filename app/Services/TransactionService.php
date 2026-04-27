<?php

namespace App\Services;

use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionService
{
    /**
     * Create a new class instance.
     */
    protected $voucherService, $insuranceService;

    public function __construct(VoucerService $voucherService, InsuranceService $insuranceService)
    {
        $this->voucherService = $voucherService;
        $this->insuranceService = $insuranceService;
    }

    public function generateInvoiceNumber()
    {
        $prefix = 'INV-' . date('Ymd');
        $lastTransaction = Transaction::where('invoice_number', 'like', $prefix . '%')
            ->orderBy('invoice_number', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNumber = intval(substr($lastTransaction->invoice_number, -4));
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        } else {
            $newNumber = '0001';
        }

        return $prefix . $newNumber;
    }

    public function getVoucherForInsurance($insuranceId)
    {
        // $today = date('Y-m-d');
        $today = date('2026-02-01');
        return \App\Models\Voucher::where('insurance_id', $insuranceId)
            ->where('start_date', '<=', $today)
            ->where('end_date', '>=', $today)
            ->first();
    }

    public function calculateVoucher($voucher, $price) 
    {
        $discount_per_item = 0;
        if ($voucher) {
            if ($voucher['type'] == 'fixed') {
                $discount_per_item = $voucher['value'];
            } else {
                $disc = $voucher['value'] / 100 * $price['unit_price'];
                $discount_per_item = round($disc);
            }

            if($voucher['max_discount'] != null || $voucher['max_discount'] >= 0) {
                $discount_per_item = $discount_per_item > $voucher['max_discount'] ? $voucher['max_discount'] : $discount_per_item;
            }
        }

        return $discount_per_item;
    }

    /**
     * Get all data.
     */
    public function getData() 
    {
        $data = Transaction::query()->orderBy('created_at', 'desc');
        return $data;
    }

    /**
     * Get data by ID.
     */
    public function findById($id)
    {
        return Transaction::findOrFail($id);
    }

    /**
     * Create a new data.
     */
    public function store(array $data) 
    {
        return Transaction::create($data);
    }

    /**
     * Update an existing data.
     */
    public function update($id, array $data)
    {
        $transaction = $this->findById($id);

        $transaction->update($data);
        return $data;
    }

    /**
     * Create a new data with details.
     */
    public function storeTransaction(array $data) 
    {
        return DB::transaction(function () use ($data) {
            $auth = Auth::user();
            
            $insurance = $this->insuranceService->getById($data['insurance_id']);
            
            $transaction = Transaction::create([
                'user_id' => $auth->id ?? null,
                'invoice_number' => $data['invoice_number'],
                'insurance_id' => $data['insurance_id'],
                'insurance_name' => $insurance['name'] ?? null,
                'voucher_id' => $data['voucher_id'] ?? null,
                'subtotal' => $data['subtotal'],
                'total_discount' => $data['total_discount'] ?? 0,
                'grand_total' => $data['grand_total'],
                'status' => 'draft',
                'created_by' => ($auth->name ?? 'System') . ' (' . ($auth->id ?? '-') . ')',
            ]);

            foreach ($data['details'] as $detail) {
                $transaction->details()->create([
                    'procedure_id' => $detail['procedure_id'],
                    'procedure_name' => $detail['procedure_name'],
                    'price_id' => $detail['price_id'],
                    'price' => $detail['price'],
                    'price_start_date' => $detail['price_start_date'],
                    'price_end_date' => $detail['price_end_date'],
                    'qty' => $detail['qty'],
                    'discount_per_item' => $detail['discount_per_item'] ?? 0,
                    'subtotal' => $detail['subtotal'],
                ]);
            }

            return $transaction;
        });
    }

    public function delete($id)
    {
        $data = $this->findById($id);
        $data->details()->delete();
        return $data->delete();
    }
}
