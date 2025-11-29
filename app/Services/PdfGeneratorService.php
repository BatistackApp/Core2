<?php

namespace App\Services;

use App\Models\Commerces\Devis;
use App\Models\Core\Company;
use App\Settings\CommercesSettings;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\View;
use Log;
use Spatie\Browsershot\Browsershot;

class PdfGeneratorService
{
    public function generateFromModel(Model $model, string $type = "Document", bool $download = false)
    {
        $data = $this->mapData($model, $type);

        $html = View::make('pdf.default', $data)->render();

        $browsershot = Browsershot::html($html)
            ->format('A4')
            ->margins(0,0,0,0)
            ->showBackground()
            ->waitUntilNetworkIdle()
            ->newHeadless();

        if (config('app.env') === 'local') {
            $browsershot->setNodeBinary('C:\\Program Files\\nodejs\\node.exe'); // Exemple Windows
            $browsershot->setNpmBinary('C:\\Program Files\\nodejs\\npm.cmd');
        }

        $browsershot->noSandbox();
        $reference = $data['reference'];

        try {
            $pdfContent = $browsershot->pdf();
            $filename = strtolower($type).'-'.($reference ?? 'doc').'.pdf';

            return response()->streamDownload(function () use ($pdfContent) {
                echo $pdfContent;
            }, $filename, [
                'Content-Type' => 'application/pdf',
            ]);
        } catch (\Exception $exception) {
            Log::error("Erreur génération PDF via Browsershot : " . $exception->getMessage());
            // Fallback ou erreur utilisateur
            abort(500, "Impossible de générer le PDF. Vérifiez la configuration Node/Puppeteer.");
        }
    }


    /**
     * Transforme les différents modèles (Order, Invoice) en un tableau standard pour la vue.
     */
    protected function mapData(Model $model, string $type): array
    {
        // Données communes par défaut
        $common = [
            'document_name' => ucfirst(strtolower($type)),
            'type' => $type,
            'company' => [
                'name' => Company::first()->name ?? 'Vortech Studio',
                'address' => Company::first()->address ?? '123 Avenue de la Innovation',
                'code_postal' => Company::first()->code_postal ?? '',
                'ville' => Company::first()->ville ?? '',
                'pays' => Company::first()->pays ?? '',
                'siret' => Company::first()->siret ?? '',
                'ape' => Company::first()->ape ?? '',
                'email' => Company::first()->email ?? '',
                'tva' => Company::first()->num_tva ?? '',
                'rcs' => Company::first()->rcs ?? '',
                'cvg' => str(app(CommercesSettings::class)->cvg)->markdown()->sanitizeHtml(),
            ],
            'logo' => asset('storage/upload/logo-company.png'), // Assurez-vous que l'URL est accessible par le script Node
            'date' => now()->format('d/m/Y'),
        ];

        // Mapping spécifique selon la classe du modèle
        if ($model instanceof Devis) {
            return array_merge($common, [
                'reference' => $model->num_devis ?? 'DVS-' . $model->id,
                'date' => $model->date_devis->format('d/m/Y'),
                'due_date' => $model->date_expired?->format('d/m/Y') ?? null, // Si le champ existe
                'status' => $model->status->label() ?? 'Brouillon',

                // Info Client
                'customer_name' => $model->tiers?->name,
                'customer_contact' => $model->tiers?->contact_first?->nom." ".$model->tiers?->contact_first?->prenom,
                'customer_address' => $model->tiers?->address_first?->address,
                'customer_zip' => $model->tiers?->address_first?->code_postal,
                'customer_city' => $model->tiers?->address_first?->ville,
                'customer_country' => $model->tiers?->address_first?->pays,

                // Lignes (Items)
                'items' => $model->lines->map(fn($item) => [
                    'name' => $item->libelle ?? $item->article->name ?? 'Produit',
                    'description' => $item->description,
                    'price' => $item->puht ?? 0,
                    'quantity' => $item->qte ?? 1,
                    'vat_rate' => $item->tva_rate ?? app(\App\Settings\CommercesSettings::class)->default_vat_rate, // À dynamiser selon votre modèle
                    'total_ht' => ($item->puht * $item->qte),
                ]),

                // Totaux
                'subtotal' => $model->amount_ht ?? 0,
                'vat_rate' => 20,
                'tax' => $model->total_vat ?? 0,
                'total' => $model->amount_ttc ?? 0,

                // Textes
                'terms' => "Devis gratuit. Les prix TTC sont établis sur la base des taux de TVA en vigueur à la date de remise de l'offre. Toute variation de ces taux sera répercutée sur les prix.",
                'bank_info' => "FR76 1234 5678 9012 3456 7890 123",
                'bank_bic' => "AGRFRZP",
            ]);
        }

        // Ajouter ici d'autres `elseif ($model instanceof Invoice)` ...

        return $common;
    }
}
