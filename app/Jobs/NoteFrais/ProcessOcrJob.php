<?php

namespace App\Jobs\NoteFrais;

use App\Enums\NoteFrais\ExpenseReceiptOcrStatus;
use App\Models\NoteFrais\ExpenseReceipt;
use Http;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Log;
use Storage;

class ProcessOcrJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public ExpenseReceipt $expenseReceipt)
    {
    }

    public function handle(): void
    {
        if (!Storage::disk('local')->exists($this->expenseReceipt->file_path)) {
            $this->fail('Fichier non trouvé pour OCR: ' . $this->expenseReceipt->file_path);
            return;
        }

        try {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . config('services.ocr.key'),
            ])
                ->attach(
                    'file',
                    Storage::disk('local')->get($this->expenseReceipt->file_path),
                    $this->expenseReceipt->filename
                )
                ->post('https://api.ocr.exemple.com/v1/parse');

            if (!$response->successful()) {
                throw new \Exception('Échec de l\'API OCR: ' . $response->body());
            }

            $data = $response->json();

            // [cite: app/Models/NoteFrais/ExpenseReceipt.php]
            $this->expenseReceipt->update([
                'ocr_raw_text' => $data['raw_text'] ?? null,
                'ocr_detected_amount' => $data['detected_amount'] ?? null,
                'ocr_detected_date' => $data['detected_date'] ?? null,
                'ocr_detected_merchant' => $data['detected_merchant'] ?? null,
                'ocr_status' => ExpenseReceiptOcrStatus::PROCESSED,
            ]);

        } catch (\Exception $e) {
            $this->expenseReceipt->update([
                'ocr_status' => ExpenseReceiptOcrStatus::FAILED,
            ]);
            Log::error('Échec OCR: ' . $e->getMessage());
        }
    }
}
