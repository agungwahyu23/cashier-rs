<?php

namespace App\Services;

use App\Helpers\Util;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class PriceProceduresService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    /**
     * Get Data from api resource
     * Keep data with cache key data-price-procedure
    */
    public function getData($idProcedure) 
    {
        return Cache::remember('data-price-procedure', now()->addMinutes(60), function () use ($idProcedure) 
        {
            $token = Util::getToken();
            $baseUrl = 'https://recruitment.rsdeltasurya.com/api/v1/procedures/'.$idProcedure.'/prices';
    
            try {
                $response = Http::withoutVerifying()
                    ->timeout(5)
                    ->retry(2, 500)
                    ->withHeaders([
                        "Authorization" => "Bearer ".$token
                    ])->get($baseUrl);
    
                $response->throw();
                        
                $data = $response->json()['prices'] ?? null;
                        
                return $data;
            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        });
    }
}
