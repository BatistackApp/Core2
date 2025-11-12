<?php

namespace Database\Factories\Signature;

use App\Models\Signature\SignatureQuota;
use Illuminate\Database\Eloquent\Factories\Factory;

class SignatureQuotaFactory extends Factory
{
    protected $model = SignatureQuota::class;

    public function definition(): array
    {
        return [
            'total_allocated' => $this->faker->randomNumber(),
            'total_used' => $this->faker->randomNumber(),
        ];
    }
}
