<?php

namespace Database\Factories\Core;

use App\Enums\Core\ServiceStatus;
use App\Models\Core\Service;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Core\Service>
 */
class ServiceFactory extends Factory
{
    protected $model = Service::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'service_code' => $this->faker->uuid(),
            'status' => ServiceStatus::OK->value,
            'storage_limit' => 10,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
