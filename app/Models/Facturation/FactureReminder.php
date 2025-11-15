<?php

namespace App\Models\Facturation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FactureReminder extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }

    protected function casts(): array
    {
        return [
            'send_at' => 'timestamp',
        ];
    }
}
