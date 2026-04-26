<?php

namespace App\Services;

use App\Helpers\Util;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ProceduresService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get Data from api resource
     * Keep data with cache key data-procedures
    */
    public function getData() 
    {
        return Cache::remember('data-procedures', now()->addMinutes(60), function () 
        {
            $token = Util::getToken();
            $baseUrl = 'https://recruitment.rsdeltasurya.com/api/v1/procedures';
    
            try {
                $response = Http::withoutVerifying()
                    ->timeout(5)
                    ->retry(2, 500)
                    ->withHeaders([
                        "Authorization" => "Bearer ".$token
                    ])->get($baseUrl);
    
                $response->throw();
                        
                $data = $response->json()['procedures'] ?? null;
                        
                return $data;
            } catch (\Throwable $e) {
                throw $e->getMessage();
            }
        });
    }

    public function getById($id)
    {
        $data = $this->getData();

        return collect($data)->firstWhere('id', $id);
    }
}
