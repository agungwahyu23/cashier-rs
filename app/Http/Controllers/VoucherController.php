<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Services\InsuranceService;
use App\Services\VoucerService;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Yajra\DataTables\Facades\DataTables;

class VoucherController extends Controller
{
    protected $voucerService, $insuranceService;
    public function __construct(
        VoucerService $voucerService,
        InsuranceService $insuranceService
    ) {
        $this->voucerService = $voucerService;
        $this->insuranceService = $insuranceService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data['title_page'] = 'Voucher';

        return view('vouchers.index', $data);
    }

    /**
     * Get data data for DataTable server-side rendering
     */
    public function getDataTable()
    {
        $data = $this->voucerService->getData();

        return DataTables::of($data)
        ->editColumn('value', function ($data) {
            if ($data['type'] === 'percentage') {
                return $data['value'] . '%';
            }
            return 'Rp ' . number_format($data['value'], 0, ',', '.');
        })
        ->editColumn('start_date', function ($data) {
            return $data['start_date'];
        })
        ->editColumn('end_date', function ($data) {
            return $data['end_date'];
        })
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
        $data['title_page'] = 'Tambah Voucher';
        $data['insurances'] = $this->insuranceService->getData();
        $data['code'] = 'V'. Carbon::now()->format('dmy').rand(11, 99);

        return view('vouchers.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'insurance_id' => 'required',
            'value' => 'required|numeric|min:0',
        ]);

        $this->voucerService->store($request->all());

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Data berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Voucher $voucher)
    {
        $data['title_page'] = 'Edit Voucher';
        $data['voucher'] = $voucher;
        $data['insurances'] = $this->insuranceService->getData();
        
        return view('vouchers.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Voucher $voucher)
    {
         $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255',
            'insurance_id' => 'required',
            'value' => 'required|numeric|min:0',
        ]);

        $this->voucerService->update($voucher->id, $request->all());

        return redirect()
            ->route('vouchers.index')
            ->with('success', 'Data berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Voucher $voucher)
    {
         try {
            $this->voucerService->delete($voucher->id);
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
