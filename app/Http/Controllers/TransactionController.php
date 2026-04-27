<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Services\InsuranceService;
use App\Services\PriceProceduresService;
use App\Services\ProceduresService;
use App\Services\TransactionService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TransactionController extends Controller
{
    protected $transactionService, $insuranceService, $proceduresService, $priceProceduresService;

    public function __construct(
        TransactionService $transactionService,
        InsuranceService $insuranceService,
        ProceduresService $proceduresService,
        PriceProceduresService $priceProceduresService
    ) {
        $this->transactionService = $transactionService;
        $this->insuranceService = $insuranceService;
        $this->proceduresService = $proceduresService;
        $this->priceProceduresService = $priceProceduresService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title_page'] = 'Transaksi';

        return view('transactions.index', $data);
    }

     /**
     * Get data data for DataTable server-side rendering
     */
    public function getDataTable()
    {
        $data = $this->transactionService->getData();

        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('vouchers.edit', $data['id']) . '" class="btn btn-warning btn-sm">Edit</a>
                    <a href="#" class="btn btn-danger btn-sm" onclick="deleteData(\'' . $data['id'] . '\')">Hapus</a>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $data['title_page'] = 'Tambah Transaksi';
        $data['invoice_number'] = $this->transactionService->generateInvoiceNumber();
        $data['insurances'] = $this->insuranceService->getData();
        $data['procedures'] = $this->proceduresService->getData();

        return view('transactions.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => 'required|string',
            'insurance_id' => 'required|string',
            'voucher_id' => 'nullable|string',
            'subtotal' => 'required|numeric',
            'total_discount' => 'nullable|numeric',
            'grand_total' => 'required|numeric',
            'details' => 'required|array|min:1',
            'details.*.procedure_id' => 'required|string',
            'details.*.procedure_name' => 'required|string',
            'details.*.price_id' => 'required|string',
            'details.*.price' => 'required|numeric',
            'details.*.price_start_date' => 'nullable',
            'details.*.price_end_date' => 'nullable',
            'details.*.discount_per_item' => 'nullable|numeric',
            'details.*.qty' => 'required|integer|min:1',
            'details.*.subtotal' => 'required|numeric',
        ]);
        
        try {
            $this->transactionService->storeTransaction($validated);
            return response()->json(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    public function getVoucher(Request $request)
    {
        $voucher = $this->transactionService->getVoucherForInsurance($request->insurance_id);
        return response()->json($voucher);
    }

    public function getPrice(Request $request)
    {
        $prices = $this->priceProceduresService->getData($request->procedure_id);
        $voucher = $this->transactionService->getVoucherForInsurance($request->insurance_id);
        
        // Find active price for today
        // $today = date('Y-m-d');
        $today = date('2026-02-01');
        $activePrice = collect($prices)->first(function($price) use ($today) {
            return $today >= $price['start_date']['value'] && $today <= $price['end_date']['value'];
        });

        $discount = $this->transactionService->calculateVoucher($voucher, $activePrice);

        return response()->json([
            'activePrice' => $activePrice,
            'discount_per_item' => $discount
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaction $transaction)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction)
    {
        //
    }
}
