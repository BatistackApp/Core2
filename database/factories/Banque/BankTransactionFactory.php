<?php

namespace Database\Factories\Banque;

use App\Models\Banque\BankAccount;
use App\Models\Banque\BankTransaction;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BankTransactionFactory extends Factory
{
    protected $model = BankTransaction::class;

    public function definition(): array
    {
        return [
            'transaction_date' => Carbon::now(),
            'value_date' => Carbon::now(),
            'label' => $this->faker->word(),
            'amount' => $this->faker->randomFloat(),
            'bank_reference' => $this->faker->word(),
            'provider_transaction_id' => $this->faker->word(),
            'is_from_sync' => $this->faker->boolean(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'bank_account_id' => BankAccount::factory(),
        ];
    }
}
