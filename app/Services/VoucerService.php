<?php

namespace App\Services;

use App\Models\Voucher;
use Illuminate\Support\Facades\Auth;

class VoucerService
{
    /**
     * Create a new class instance.
     */
    protected $insuranceService;
    public function __construct(InsuranceService $insuranceService)
    {
        $this->insuranceService = $insuranceService;
    }

    /**
     * Get all data.
     */
    public function getData() 
    {
        $data = Voucher::query()->orderBy('created_at', 'desc');
        return $data;
    }

    /**
     * Get data by ID.
     */
    public function findById($id)
    {
        return Voucher::findOrFail($id);
    }

    /**
     * Create a new data.
     * Lakukan pengecekan untuk rule tiap asuransi tidak boleh ada voucher dengan periode yang saling overlap
     */
    public function store(array $data) 
    {
        $auth = Auth::user();
        $start = $data['start_date'];
        $end = $data['end_date'];

        $exists = Voucher::where('insurance_id', $data['insurance_id'])
                            ->where(function ($q) use ($start, $end) {
                                $q->whereBetween('start_date', [$start, $end])
                                ->orWhereBetween('end_date', [$start, $end])
                                ->orWhere(function ($q2) use ($start, $end) {
                                    $q2->where('start_date', '<=', $start)
                                        ->where('end_date', '>=', $end);
                                });
                            })
                            ->exists();
        if ($exists) 
        {
            return back()->withErrors([
                'date' => 'Voucher untuk asuransi ini sudah ada pada rentang tanggal tersebut.'
            ]);
        }

        $data['created_by'] = $auth['name'] . ' (' . $auth['id'].')';
        $data['insurance_name'] = $this->insuranceService->getById($data['insurance_id'])['name'];

        return Voucher::create($data);    
    }

    /**
     * Update an existing data.
     */
    public function update($id, array $data)
    {
        $voucher = $this->findById($id);
        $data['insurance'] = $this->insuranceService->getById($data['insurance_id']);
        $data['insurance_name'] = $this->insuranceService->getById($data['insurance_id'])['name'];

        $voucher->update($data);
        return $data;
    }

    /**
     * Delete a data.
     */
    public function delete($id)
    {
        $data = $this->findById($id);
        return $data->delete();
    }
}
