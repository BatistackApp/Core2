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
                return $request->json();
            } else {
                return true;
            }
        }else {
            return false;
        }
    }
}