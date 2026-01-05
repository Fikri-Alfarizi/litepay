<?php

namespace App\Services;

class SignatureService
{
    /**
     * Generate signature for the given data and secret.
     *
     * @param array $data
     * @param string $secret
     * @return string
     */
    public function generate(array $data, string $secret): string
    {
        // Sort keys to ensure consistency? Or simply JSON encode?
        // Usually raw body is signed. For this simulation, let's assume JSON body.
        // Or if $data is array, we might json_encode it.
        // Let's assume we sign the JSON string of the request body.
        
        $payload = json_encode($data);
        return hash_hmac('sha256', $payload, $secret);
    }

    /**
     * Verify the signature.
     *
     * @param string $signature
     * @param string $payload (raw body)
     * @param string $secret
     * @return bool
     */
    public function verify(string $signature, string $payload, string $secret): bool
    {
        $calculated = hash_hmac('sha256', $payload, $secret);
        return hash_equals($calculated, $signature);
    }
}
