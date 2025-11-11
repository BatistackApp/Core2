<?php

namespace Database\Factories\Commerces;

use App\Models\Commerces\Devis;
use App\Models\Commerces\DevisLigne;
use Illuminate\Database\Eloquent\Factories\Factory;

class DevisLigneFactory extends Factory
{
    protected $model = DevisLigne::class;

    public function definition(): array
    {
        $qte = $this->faker->randomFloat(2);
        $puht = $this->faker->randomFloat(2, 1, 7000);

        return [
            'type' => array_rand([
                'product' => 'product',
                'service' => 'service',
                'fabrication' => 'fabrication',
            ]),
            'libelle' => $this->faker->word(),
            'description' => $this->faker->boolean(25) ? $this->faker->text() : null,
            'qte' => $qte,
            'puht' => $puht,
            'amount_ht' => $qte * $puht,
            'tva_rate' => 20,

            'devis_id' => Devis::factory(),
        ];
    }
}
