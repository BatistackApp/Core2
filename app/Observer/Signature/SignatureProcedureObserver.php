<?php

namespace App\Observer\Signature;

use App\Enums\Signature\SignatureProcedureStatus;
use App\Jobs\Signature\SendSignatureRequestEmailJob;
use App\Models\Signature\SignatureLog;
use App\Models\Signature\SignatureProcedure;
use App\Models\Signature\SignatureQuota;
use Log;

class SignatureProcedureObserver
{
    /**
     * @throws \Exception
     */
    public function creating(SignatureProcedure $procedure): void
    {
        $quota = SignatureQuota::firstOrCreate(
            ['total_allocated' => 0, 'total_used' => 0] // Crée un quota à 0 si inexistant
        );

        // [cite: modules/Signature/architecture.md] (Logique 1)
        if ($quota->isQuotaExceeded()) {
            Log::warning("Quota de signatures dépassé.");
            // Vous pouvez lancer une exception ici pour arrêter la création
            throw new \Exception("Quota de signatures dépassé.");
        }
    }

    public function created(SignatureProcedure $procedure): void
    {
        SignatureLog::create([
            'procedure_id' => $procedure->id,
            'event_type' => 'procedure_created',
            'details' => 'Procédure créée par ' . $procedure->user->name,
        ]);
    }

    public function updated(SignatureProcedure $procedure): void
    {
        // Si la procédure passe au statut "Envoyé"
        if ($procedure->wasChanged('status') && $procedure->status === SignatureProcedureStatus::SENT) {

            // [cite: modules/Signature/architecture.md] (Logique 3.a)
            // Incrémenter le quota
            $quota = SignatureQuota::first();
            if ($quota) {
                $quota->increment('total_used');
            }

            // [cite: modules/Signature/architecture.md] (Logique 3.b & 3.c)
            // Envoyer les emails
            $signersQuery = $procedure->signers();
            if ($procedure->ordering_enabled) {
                // Si ordonné, on envoie seulement au premier
                $signersQuery->where('order', 1);
            }

            foreach ($signersQuery->get() as $signer) {
                SendSignatureRequestEmailJob::dispatch($signer);
            }
        }

        // Si la procédure passe au statut "Terminé"
        if ($procedure->wasChanged('status') && $procedure->status === SignatureProcedureStatus::COMPLETED) {
            // [cite: modules/Signature/architecture.md] (Logique 5)
            SignatureLog::create([
                'procedure_id' => $procedure->id,
                'event_type' => 'procedure_completed',
                'details' => 'Procédure complétée et verrouillée.',
            ]);

            // Mettre à jour le document GED
            // [cite: app/Models/Document.php]
            $procedure->document->update([
                'is_signed' => true,
                'signed_at' => now(),
            ]);
        }
    }
}
