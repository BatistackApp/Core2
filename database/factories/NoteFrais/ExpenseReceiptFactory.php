<?php

namespace Database\Factories\NoteFrais;

use App\Models\NoteFrais\Expense;
use App\Models\NoteFrais\ExpenseReceipt;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ExpenseReceiptFactory extends Factory
{
    protected $model = ExpenseReceipt::class;

    public function definition(): array
    {
        return [
            'file_path' => $this->faker->word(),
            'filename' => $this->faker->word(),
            'mime_type' => $this->faker->word(),
            'size' => $this->faker->randomNumber(),
            'ocr_raw_text' => $this->faker->text(),
            'ocr_detected_amount' => $this->faker->randomFloat(),
            'ocr_detected_date' => Carbon::now(),
            'ocr_detected_merchant' => $this->faker->word(),
            'ocr_status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'expense_id' => Expense::factory(),
        ];
    }
}
