<?php

namespace App\Models\Signature;

use App\Enums\Signature\SignatureProcedureStatus;
use App\Models\GED\Document;
use App\Models\User;
use App\Observer\Signature\SignatureProcedureObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[ObservedBy([SignatureProcedureObserver::class])]
class SignatureProcedure extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }

    public function signers(): HasMany
    {
        return $this->hasMany(SignatureSigner::class, 'procedure_id');
    }

    public function logs(): HasMany
    {
        return $this->hasMany(SignatureLog::class, 'procedure_id');
    }

    protected function casts(): array
    {
        return [
            'status' => SignatureProcedureStatus::class, // Cast vers l'Enum
            'ordering_enabled' => 'boolean',
            'sent_at' => 'datetime',
            'completed_at' => 'datetime',
            'expires_at' => 'datetime',
        ];
    }
}
