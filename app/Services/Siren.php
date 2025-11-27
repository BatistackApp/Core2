<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;
use Log;

class Siren
{
    public function call(string $siren, string $type = 'info', bool $etab = false): mixed
    {

        if($etab) {
            $url = 'https://api.insee.fr/api-sirene/3.11/siret/'.$siren;
        } else {
            $url = 'https://api.insee.fr/api-sirene/3.11/siren/'.$siren;
        }

        $request = Http::withoutVerifying()
            ->withHeaders([
                'X-INSEE-Api-Key-Integration' => config('services.siren_api.key'),
            ])
            ->get($url);


        if($request->status() === 200) {
            if($type === 'info') {
                $info = $request->object();
                $bodacc = $this->getBodaccInfo($siren);
                return collect()->push([
                    "information" => $info,
                    "bodacc" => $bodacc ?? []
                ])->toArray();
            } else {
                return true;
            }
        }else {
            return false;
        }
    }

    public function getBodaccInfo(string $siren): array
    {
        return Http::withoutVerifying()
            ->get('https://www.bodacc.fr/api/explore/v2.1/catalog/datasets/annonces-commerciales/records?where=registre:"'.$siren.'"&limit=20')
            ->object()->results;
    }

    public function searchEntreprise(string $entreprise, int $limit = 10): array|\Illuminate\Support\Collection
    {
        if (strlen($entreprise) < 3) {
            return collect();
        }

        try {
            $response = Http::withoutVerifying()
                ->timeout(5)
                ->get('https://recherche-entreprises.api.gouv.fr/search', [
                    'q' => $entreprise,
                    'per_page' => $limit,
                    'page' => 1,
                ]);

            if ($response->failed()) {
                Log::warning('SireneApiService: Erreur API HTTP', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'query' => $entreprise
                ]);
                return collect();
            }

            $data = $response->json();

            // Sécurité : si l'API ne renvoie pas un tableau (ex: erreur rate limit en JSON)
            if (!is_array($data)) {
                Log::warning('SireneApiService: Format de réponse inattendu', ['data' => $data]);
                return collect();
            }

            return collect($data);
        }catch (\Exception $exception) {
            Log::emergency('SireneApiService: Exception connexion', ['message' => $exception->getMessage()]);
            return collect();
        }
    }
}
