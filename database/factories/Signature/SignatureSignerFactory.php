<?php

namespace Database\Factories\Signature;

use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureSigner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class SignatureSignerFactory extends Factory
{
    protected $model = SignatureSigner::class;

    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail(),
            'name' => $this->faker->name(),
            'status' => $this->faker->word(),
            'order' => $this->faker->randomNumber(),
            'token' => Str::random(10),
            'sent_at' => Carbon::now(),
            'viewed_at' => Carbon::now(),
            'signed_at' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'procedure_id' => SignatureProcedure::factory(),
        ];
    }
}
