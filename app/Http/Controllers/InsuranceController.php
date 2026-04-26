<?php

namespace App\Http\Controllers;

use App\Services\InsuranceService;
use Yajra\DataTables\Facades\DataTables;

class InsuranceController extends Controller
{
    protected $insuranceService;

    public function __construct(InsuranceService $insuranceService)
    {
        $this->insuranceService = $insuranceService;
    }

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $data['title_page'] = 'Asuransi';

        return view('insurances.index', $data);
    }

    /**
     * Get data data for DataTable server-side rendering
     */
    public function getDataTable()
    {
        $data = $this->insuranceService->getData();

        return DataTables::of($data)
            ->rawColumns(['action'])
            ->toJson();
    }
}
