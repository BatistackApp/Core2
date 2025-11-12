<?php

namespace Database\Factories\Signature;

use App\Models\Signature\SignatureLog;
use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureSigner;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class SignatureLogFactory extends Factory
{
    protected $model = SignatureLog::class;

    public function definition(): array
    {
        return [
            'event_type' => $this->faker->word(),
            'ip_address' => $this->faker->ipv4(),
            'user_agent' => $this->faker->word(),
            'detail' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'procedure_id' => SignatureProcedure::factory(),
            'signer_id' => SignatureSigner::factory(),
        ];
    }
}
