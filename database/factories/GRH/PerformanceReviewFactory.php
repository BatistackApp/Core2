<?php

namespace Database\Factories\GRH;

use App\Models\GRH\PerformanceReview;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class PerformanceReviewFactory extends Factory
{
    protected $model = PerformanceReview::class;

    public function definition(): array
    {
        return [
            'review_date' => Carbon::now(),
            'rating' => $this->faker->randomNumber(),
            'strengths' => $this->faker->word(),
            'weaknesses' => $this->faker->word(),
            'goals' => $this->faker->word(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'user_id' => User::factory(),
            'reviewer_id' => User::factory(),
        ];
    }
}
