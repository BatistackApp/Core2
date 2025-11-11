<?php

namespace App\Models\Facturation;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FacturePayment extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected $table = 'facture_payment';

    public function facture(): BelongsTo
    {
        return $this->belongsTo(Facture::class);
    }

    public function payment(): BelongsTo
    {
        return $this->belongsTo(Payment::class);
    }
}
