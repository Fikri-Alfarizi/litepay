<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use App\Models\Transaction;
use App\Models\Merchant;
use App\Models\CallbackLog;
use Carbon\Carbon;

class GeminiService
{
    protected $apiKey;
    protected $baseUrl = 'https://generativelanguage.googleapis.com/v1beta/models/';
    protected $model = 'gemini-2.5-flash';

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
    }

    public function chat(string $message, array $history = [], string $context = 'general')
    {
        if (!$this->apiKey) {
            return [
                'error' => 'API Key is missing. Please add GEMINI_API_KEY to your .env file.'
            ];
        }

        // Get Real-time Database Context
        $dbContext = $this->getDatabaseContext();
        $systemPrompt = $this->getSystemPrompt($context) . "\n\n[DATA SISTEM REAL-TIME]\n" . $dbContext;
        
        // Format history for Gemini API
        $formattedHistory = [];
        
        foreach ($history as $msg) {
            $role = $msg['role'] === 'user' ? 'user' : 'model';
            $formattedHistory[] = [
                'role' => $role,
                'parts' => [['text' => $msg['content']]]
            ];
        }

        // Add the current user message with system prompt instructions
        $formattedHistory[] = [
            'role' => 'user',
            'parts' => [['text' => $systemPrompt . "\n\nUser Question: " . $message]]
        ];

        try {
            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
            ])->post("{$this->baseUrl}{$this->model}:generateContent?key={$this->apiKey}", [
                'contents' => $formattedHistory,
                'generationConfig' => [
                    'temperature' => 0.7,
                    'maxOutputTokens' => 1000,
                ]
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $generatedText = $data['candidates'][0]['content']['parts'][0]['text'] ?? 'Maaf, saya tidak dapat menghasilkan respons.';
                
                return [
                    'success' => true,
                    'message' => $generatedText
                ];
            } else {
                Log::error('Gemini API Error: ' . $response->body());
                return [
                    'error' => 'API Error: ' . $response->status()
                ];
            }

        } catch (\Exception $e) {
            Log::error('Gemini Service Exception: ' . $e->getMessage());
            return [
                'error' => 'Terjadi kesalahan saat menghubungkan ke layanan AI.'
            ];
        }
    }

    protected function getDatabaseContext()
    {
        try {
            // Transactions
            $today = Carbon::today();
            $trxTotal = Transaction::count();
            $trxToday = Transaction::whereDate('created_at', $today)->count();
            $trxSuccess = Transaction::where('status', 'PAID')->count();
            $trxPending = Transaction::where('status', 'PENDING')->count();
            $trxFailed = Transaction::whereIn('status', ['FAILED', 'EXPIRED'])->count();
            
            $revenueTotal = Transaction::where('status', 'PAID')->sum('amount');
            $revenueToday = Transaction::where('status', 'PAID')->whereDate('paid_at', $today)->sum('amount');
            
            // Merchants
            $merchantsTotal = Merchant::count();
            $merchantsActive = Merchant::where('status', 'active')->count();

            // Recent System Issues (Callbacks)
            $recentErrors = CallbackLog::where('response_status', '!=', 200)
                ->latest()
                ->take(3)
                ->get()
                ->map(function($log) {
                    return "Trx ID {$log->transaction_id}: HTTP {$log->response_status}";
                })->implode(', ');

            return <<<EOT
- Total Transaksi: $trxTotal ($trxToday hari ini)
- Status Transaksi: $trxSuccess Sukses, $trxPending Pending, $trxFailed Gagal
- Total Pendapatan: Rp " . number_format($revenueTotal, 0, ',', '.') . " (" . number_format($revenueToday, 0, ',', '.') . " hari ini)
- Total Merchant: $merchantsTotal ($merchantsActive aktif)
- Isu Sistem Terkini: " . ($recentErrors ?: 'Tidak ada isu kritikal') . "
EOT;
        } catch (\Exception $e) {
            return "Gagal mengambil data sistem: " . $e->getMessage();
        }
    }

    protected function getSystemPrompt($context)
    {
        $basePrompt = "Anda adalah LitePay AI, asisten yang SANGAT PINTAR dan MEMILIKI AKSES PENUH ke data database LitePay Pro. Jawab pertanyaan berdasarkan [DATA SISTEM REAL-TIME] yang diberikan. JANGAN gunakan emoji. Gunakan Bahasa Indonesia formal.";

        switch ($context) {
            case 'analyze':
                return $basePrompt . " Anda adalah ANALIS DATA ahli. Berikan wawasan mendalam berdasarkan angka-angka di atas. Tunjukkan tren atau masalah (misal: tingkat kegagalan tinggi).";
            case 'support':
                return $basePrompt . " Anda adalah Technical Support. Gunakan data transaksi untuk membantu pengguna. Jika ada error callback, sebutkan secara spesifik.";
            case 'creative':
                return $basePrompt . " Anda adalah Copywriter. Gunakan data untuk membuat konten relevan (misal: rayakan pencapaian transaksi).";
            case 'general':
            default:
                return $basePrompt . " Jawab pertanyaan apa pun tentang sistem LitePay, saldo, atau pedagang berdasarkan data yang Anda baca.";
        }
    }
}
