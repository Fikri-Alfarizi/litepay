<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifyApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $apiKey = $request->header('X-API-KEY');
        
        if (!$apiKey) {
            return response()->json(['message' => 'API Key is missing'], 401);
        }

        $merchant = \App\Models\Merchant::where('api_key', $apiKey)->where('status', 'active')->first();

        if (!$merchant) {
            return response()->json(['message' => 'Invalid API Key'], 401);
        }

        // Attach merchant to the request object for downstream usage
        $request->attributes->set('merchant', $merchant);

        return $next($request);
    }
}
