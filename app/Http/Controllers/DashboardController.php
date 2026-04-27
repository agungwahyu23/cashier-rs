<?php

namespace App\Http\Controllers;

use App\Services\MarketingService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $marketingService;

    public function __construct(MarketingService $marketingService)
    {
        $this->marketingService = $marketingService;
    }

    public function index()
    {
        $data = $this->marketingService->getDashboardData();
        $data['title_page'] = 'Dashboard Marketing';
        
        return view('dashboard', $data);
    }
}
