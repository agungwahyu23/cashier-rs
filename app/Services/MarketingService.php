<?php

namespace App\Services;

use App\Repositories\MarketingRepository;

class MarketingService
{
    protected $marketingRepository;

    public function __construct(MarketingRepository $marketingRepository)
    {
        $this->marketingRepository = $marketingRepository;
    }

    /**
     * Get all data needed for marketing dashboard
     */
    public function getDashboardData()
    {
        return [
            'insurance_visits' => $this->marketingRepository->getInsuranceVisits(),
            'insurance_payments' => $this->marketingRepository->getInsurancePayments(),
            'monthly_revenue' => $this->marketingRepository->getMonthlyRevenue(),
            'stats' => $this->marketingRepository->getTotalStats(),
        ];
    }
}
