<?php

namespace App\Http\Controllers;

use App\Models\CallbackLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class CallbackController extends Controller
{
    public function handle(Request $request)
    {
        // Log incoming request
        Log::info('Callback received', $request->all());

        // Validate signature (Optional but recommended, skipped for simplicity as per requirement)
        // $signature = $request->header('X-Signature');

        $reference = $request->input('reference_id');
        $status = $request->input('status');

        $transaction = Transaction::where('reference_id', $reference)->first();

        if (!$transaction) {
            return response()->json(['message' => 'Transaction not found'], 404);
        }

        // Update transaction status
        $transaction->update([
            'status' => $status,
            'paid_at' => $status === 'paid' ? now() : null,
        ]);

        // Log callback
        $transaction->website_callback_logs()->create([
            'payload' => json_encode($request->all()),
            'status' => 'processed', // or 'success'
            'response' => '200 OK',
        ]);

        // Send callback to merchant via background job (Queue) or direct HTTP
        if ($transaction->merchant->callback_url) {
            try {
                Http::timeout(5)->post($transaction->merchant->callback_url, [
                    'reference_id' => $transaction->reference_id,
                    'status' => $transaction->status,
                    'amount' => $transaction->amount,
                ]);
            } catch (\Exception $e) {
                Log::error('Failed to send callback to merchant: ' . $e->getMessage());
            }
        }

        return response()->json(['message' => 'Callback processed']);
    }
}
