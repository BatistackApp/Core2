<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use HasFactory;
    protected $guarded = [];

    public $timestamps = false;

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
        ];
    }
}
