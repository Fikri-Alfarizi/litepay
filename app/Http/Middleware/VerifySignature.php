<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerifySignature
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $signature = $request->header('X-SIGNATURE');
        
        if (!$signature) {
            return response()->json(['message' => 'Signature is missing'], 403);
        }

        $merchant = $request->attributes->get('merchant');

        if (!$merchant) {
            // Should verify api key first
            return response()->json(['message' => 'Merchant context missing'], 500);
        }

        $service = new \App\Services\SignatureService();
        
        if (!$service->verify($signature, $request->getContent(), $merchant->api_secret)) {
            return response()->json(['message' => 'Invalid Signature'], 403);
        }

        return $next($request);
    }
}
