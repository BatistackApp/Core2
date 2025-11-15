<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

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
}
