<?php

namespace App\Http\Controllers;

use App\Services\PriceProceduresService;
use App\Services\ProceduresService;
use Yajra\DataTables\Facades\DataTables;

class ProceduresController extends Controller
{
    protected $proceduresService, $priceProceduresService;

    public function __construct(
        ProceduresService $proceduresService,
        PriceProceduresService $priceProceduresService
    ) {
        $this->proceduresService = $proceduresService;
        $this->priceProceduresService = $priceProceduresService;
    }

    /**
     * Display a listing of the resource.
    */
    public function index()
    {
        $data['title_page'] = 'Tindakan Medis';

        return view('procedures.index', $data);
    }

    /**
     * Get data data for DataTable server-side rendering
     */
    public function getDataTable()
    {
        $data = $this->proceduresService->getData();

        return DataTables::of($data)
        ->addColumn('action', function ($data) {
                return '
                    <a href="' . route('procedures.show', $data['id']) . '" class="btn btn-primary btn-sm">Detail</a>
                ';
            })
            ->rawColumns(['action'])
            ->toJson();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $procedure = $this->proceduresService->getById($id);
        $priceProcedure = $this->priceProceduresService->getData($id);
        if (!$procedure) {
            return redirect()->route('procedures.index')->with('error', 'Tindakan Medis tidak ditemukan');
        }
        
        $data['title_page'] = 'Detail Tindakan Medis';
        $data['procedure'] = $procedure;
        $data['price_procedure'] = $priceProcedure;
        
        return view('procedures.show', $data);
    }
}
