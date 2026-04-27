<?php

namespace App\Repositories;

use App\Models\Transaction;
use Illuminate\Support\Facades\DB;

class MarketingRepository
{
    /**
     * Get insurance by total visits (transaction count)
     */
    public function getInsuranceVisits($limit = 5)
    {
        return Transaction::select('insurance_name', DB::raw('count(*) as total_visits'))
            ->groupBy('insurance_name')
            ->orderBy('total_visits', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get insurance by total payments (revenue)
     */
    public function getInsurancePayments($limit = 5)
    {
        return Transaction::select('insurance_name', DB::raw('sum(grand_total) as total_payments'))
            ->where('status', 'paid')
            ->groupBy('insurance_name')
            ->orderBy('total_payments', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get monthly revenue for the current year
     */
    public function getMonthlyRevenue()
    {
        return Transaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(grand_total) as total_revenue')
            )
            ->where('status', 'paid')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    /**
     * Get total statistics
     */
    public function getTotalStats()
    {
        return [
            'total_revenue' => Transaction::where('status', 'paid')->sum('grand_total'),
            'total_transactions' => Transaction::count(),
            'paid_transactions' => Transaction::where('status', 'paid')->count(),
            'total_insurance_partners' => Transaction::distinct('insurance_id')->count('insurance_id'),
        ];
    }
}
