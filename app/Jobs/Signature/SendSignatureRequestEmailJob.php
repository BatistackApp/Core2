<?php

namespace App\Jobs\Signature;

use App\Enums\Signature\SignatureSignerStatus;
use App\Models\Signature\SignatureLog;
use App\Models\Signature\SignatureSigner;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Notification;

class SendSignatureRequestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public SignatureSigner $signer)
    {
    }

    public function handle(): void
    {
        // Mettre à jour le statut du signataire
        $this->signer->update([
            'status' => SignatureSignerStatus::SENT,
            'sent_at' => now(),
        ]);

        SignatureLog::create([
            'procedure_id' => $this->signer->procedure_id,
            'signer_id' => $this->signer->id,
            'event_type' => 'email_sent',
            'details' => 'Email de demande envoyé à ' . $this->signer->email,
        ]);

        // Envoyer la notification par email
        Notification::route('mail', $this->signer->email)
            ->notify(new SignatureRequestNotification($this->signer));
    }
}
