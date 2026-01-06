<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Merchant;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    protected $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    public function create(Request $request)
    {
        // 1. Validate Request
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'order_id' => 'required|string', // Merchant's unique order ID
            'product_name' => 'required|string',
            'customer_phone' => 'nullable|string',
            'return_url' => 'nullable|url',
            'callback_url' => 'nullable|url', // Optional override
        ]);

        // 2. Retrieve Merchant from Middleware
        $merchant = $request->attributes->get('merchant');
        
        if (!$merchant) {
             // Fallback if middleware wasn't used, though it should be.
             return response()->json(['message' => 'Merchant context missing'], 500);
        }

        // 3. Create Transaction
        try {
            $transaction = $this->paymentService->createTransaction($merchant, [
                'invoice_id' => $request->order_id, // Use merchant's order ID as invoice ID ? Or map it differently?
                // Better approach: Use internal invoice_id, store merchant's ref in description or separate field?
                // For this MVP, we'll try to use order_id as invoice_id but handle duplicates carefully or separate them.
                // Let's use auto-generated invoice_id for system, and maybe store order_id if we had a column.
                // Since we don't have 'merchant_ref' column, let's just stick to our Invoice ID logic for now
                // OR assuming 'invoice_id' IS the merchant's ref.
                'invoice_id' => $request->order_id, 
                'amount' => $request->amount,
                'product_name' => $request->product_name,
                'destination_number' => $request->customer_phone,
                'payment_channel' => 'auto_detect',
            ]);

            // Save callback override if provided (Need to update DB? or just use merchant default for now)
            // For simplicity, we use merchant default or if we want per-tx, we need a column.
            // Let's assume global merchant callback for now.

            return response()->json([
                'success' => true,
                'message' => 'Transaction created successfully',
                'data' => [
                    'reference_id' => $transaction->reference_id,
                    'checkout_url' => route('checkout.show', $transaction->reference_id),
                    'amount' => $transaction->total_amount,
                    'status' => $transaction->status,
                    'expiry_time' => now()->addDay()->toIso8601String(), // 24h default
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to create transaction: ' . $e->getMessage()
            ], 500);
        }
    }
}
