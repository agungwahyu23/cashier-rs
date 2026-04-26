<?php

namespace App\Http\Controllers;

use App\Services\PriceProceduresService;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PriceProceduresController extends Controller
{
    protected $priceProceduresService;

    public function __construct(PriceProceduresService $priceProceduresService) 
    {
        $this->priceProceduresService = $priceProceduresService;
    }

    /**
     * Get data data for DataTable server-side rendering
     */
    public function getDataTable($procedure_id)
    {
        $data = $this->priceProceduresService->getData($procedure_id);

        return DataTables::of($data)
            ->toJson();
    }
}
