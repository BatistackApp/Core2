<?php

namespace App\Models\Signature;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SignatureLog extends Model
{
    use HasFactory;
    protected $guarded = [];

    const UPDATED_AT = null;

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(SignatureProcedure::class, 'procedure_id');
    }

    public function signer(): BelongsTo
    {
        return $this->belongsTo(SignatureSigner::class, 'signer_id');
    }
}
