<?php

namespace App\Models\Signature;

use App\Enums\Signature\SignatureSignerStatus;
use App\Models\Tiers\TiersContact;
use App\Models\User;
use App\Observer\Signature\SignatureSignerObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Str;

#[ObservedBy([SignatureSignerObserver::class])]
class SignatureSigner extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function procedure(): BelongsTo
    {
        return $this->belongsTo(SignatureProcedure::class, 'procedure_id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function contact(): BelongsTo
    {
        return $this->belongsTo(TiersContact::class); // Module Tiers
    }

    /**
     * Générer un token unique lors de la création.
     */
    protected static function boot(): void
    {
        parent::boot();
        static::creating(function ($signer) {
            $signer->token = (string) Str::uuid();
        });
    }

    protected function casts(): array
    {
        return [
            'status' => SignatureSignerStatus::class, // Cast vers l'Enum
            'order' => 'integer',
            'sent_at' => 'datetime',
            'viewed_at' => 'datetime',
            'signed_at' => 'datetime',
        ];
    }
}
