<?php

namespace Database\Factories\Comptabilite;

use App\Models\Comptabilite\AccountingEntry;
use App\Models\Comptabilite\AccountingJournal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class AccountingEntryFactory extends Factory
{
    protected $model = AccountingEntry::class;

    public function definition(): array
    {
        return [
            'entry_date' => Carbon::now(),
            'reference' => $this->faker->word(),
            'label' => $this->faker->word(),
            'fiscal_year' => $this->faker->randomNumber(),
            'status' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'journal_id' => AccountingJournal::factory(),
        ];
    }
}
