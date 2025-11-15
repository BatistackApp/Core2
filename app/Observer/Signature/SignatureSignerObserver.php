<?php

namespace App\Observer\Signature;

use App\Enums\Signature\SignatureProcedureStatus;
use App\Enums\Signature\SignatureSignerStatus;
use App\Jobs\Signature\SendSignatureRequestEmailJob;
use App\Models\Signature\SignatureLog;
use App\Models\Signature\SignatureSigner;
use Illuminate\Support\Facades\Request;

class SignatureSignerObserver
{
    public function updated(SignatureSigner $signer): void
    {
        // Si le signataire vient de signer
        if ($signer->wasChanged('status') && $signer->status === SignatureSignerStatus::SIGNED) {

            // [cite: modules/Signature/architecture.md] (Logique 4.a)
            SignatureLog::create([
                'procedure_id' => $signer->procedure_id,
                'signer_id' => $signer->id,
                'event_type' => 'document_signed',
                'ip_address' => Request::ip(),
                'user_agent' => Request::userAgent(),
                'details' => 'Document signé par ' . $signer->email,
            ]);

            $procedure = $signer->procedure;

            // [cite: modules/Signature/architecture.md] (Logique 4.b)
            // Vérifier si on passe au suivant (si ordonné) ou si c'est fini
            if ($procedure->ordering_enabled) {
                $nextSigner = $procedure->signers()
                    ->where('order', '>', $signer->order)
                    ->orderBy('order', 'asc')
                    ->first();

                if ($nextSigner) {
                    // Il y a un suivant : on lui envoie l'email
                    SendSignatureRequestEmailJob::dispatch($nextSigner);
                } else {
                    // C'était le dernier : on complète la procédure
                    $procedure->update(['status' => SignatureProcedureStatus::COMPLETED]);
                }

            } else {
                // Non ordonné : on vérifie si tous les autres ont signé
                $allSigned = $procedure->signers()
                    ->where('status', '!=', SignatureSignerStatus::SIGNED)
                    ->doesntExist();

                if ($allSigned) {
                    $procedure->update(['status' => SignatureProcedureStatus::COMPLETED]);
                }
            }
        }
    }
}
