<?php

namespace Database\Factories\Banque;

use App\Models\Banque\BankAccount;
use App\Models\Banque\BankConnection;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BankAccountFactory extends Factory
{
    protected $model = BankAccount::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'type' => $this->faker->word(),
            'bank_name' => $this->faker->name(),
            'iban' => $this->faker->word(),
            'bic' => $this->faker->word(),
            'currency' => $this->faker->word(),
            'current_balance' => $this->faker->randomFloat(),
            'is_default' => $this->faker->boolean(),
            'provider_account_id' => $this->faker->word(),
            'sync_enabled' => $this->faker->boolean(),
            'account_last_synced_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'bank_connection_id' => BankConnection::factory(),
        ];
    }
}
