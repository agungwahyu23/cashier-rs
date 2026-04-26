<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class Util
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public static function getToken() 
    {
        /** @var Response $response */
        return Cache::remember('token_login', now()->addMinutes(60), function () 
        {
            $response = Http::post("https://recruitment.rsdeltasurya.com/api/v1/auth", [
                    "email" => config('services.auth.email'),
                    "password" => config('services.auth.password'),
                ]);
    
            $response->throw();
    
            $token = $response->json('access_token');
    
            if (!$token) {
                throw new \Exception('Token not found in API response');
            }
    
            return $token;
        });
    }
}
