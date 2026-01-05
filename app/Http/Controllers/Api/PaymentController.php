<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function create(\App\Http\Requests\CreatePaymentRequest $request, \App\Services\PaymentService $paymentService)
    {
        // Merchant is already validated and attached by VerifyApiKey middleware
        $merchant = $request->attributes->get('merchant');

        // Check for duplicate invoice_id for this merchant
        $exists = \App\Models\Transaction::where('merchant_id', $merchant->id)
            ->where('invoice_id', $request->invoice_id)
            ->exists();

        if ($exists) {
            return response()->json([
                'success' => false,
                'message' => 'Duplicate invoice_id',
            ], 409);
        }

        try {
            $transaction = $paymentService->createTransaction($merchant, $request->validated());

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => [
                    'invoice_id' => $transaction->invoice_id,
                    'reference_id' => $transaction->reference_id,
                    'payment_url' => url('/payment/pay/' . $transaction->reference_id), // Simulation URL
                    'status' => $transaction->status,
                ]
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
