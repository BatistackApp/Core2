<?php

namespace Database\Factories\Vision;

use App\Models\Vision\BimLink;
use App\Models\Vision\BimModel;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BimLinkFactory extends Factory
{
    protected $model = BimLink::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),

            'bim_object_id' => BimModel::factory(),
        ];
    }
}
