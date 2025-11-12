<?php

namespace Database\Factories\Signature;

use App\Models\GED\Document;
use App\Models\Signature\SignatureProcedure;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SignatureProcedureFactory extends Factory
{
    protected $model = SignatureProcedure::class;

    public function definition(): array
    {
        return [
            'subject' => $this->faker->word(),
            'message' => $this->faker->word(),
            'status' => $this->faker->word(),
            'ordering_enabled' => $this->faker->boolean(),
            'sent_at' => Carbon::now(),
            'completed_at' => Carbon::now(),
            'expires_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'document_id' => Document::factory(),
        ];
    }
}
