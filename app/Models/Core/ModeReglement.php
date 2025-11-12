<?php

declare(strict_types=1);

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeReglement extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $guarded = [];

    protected function casts(): array
    {
        return [
            'bridgeable' => 'boolean',
            'type_paiement' => 'array',
        ];
    }
}
