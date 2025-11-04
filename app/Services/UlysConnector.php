<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class UlysConnector
{
    protected string $api_key;
    protected string $endpoint;
    private string $initiator;

    public function __construct()
    {
        $this->api_key = config('connector.ulys.api_key');
        $this->initiator = config('connector.ulys.initiator');
        if (config('app.env') === 'local' && config('app.env') === 'staging') {
            $this->endpoint = 'https://ulys-api-partner-sandbox.vinci-autoroutes.com/api/';
        } else {
            $this->endpoint = 'https://ulys-api-partner.vinci-autoroutes.com/api/';
        }
    }

    public function get(string $path, ?array $data = null): null|array
    {
        $url = $this->endpoint . $path;

        if (config('app.env') === 'local' && config('app.env') === 'staging') {
            $this->clearMemory();
        }

        try {
            $request = Http::withoutVerifying()
                ->withHeader('x-initiator', $this->initiator)
                ->withToken($this->api_key)
                ->get($url, $data);

            return $request->json();
        } catch (\Exception $e) {
            \Log::critical("ULYS API ERROR", ['Exception' => $e]);
            return null;
        }
    }

    private function clearMemory(): void
    {
        try {
            $this->get('sandboxmemory/clearsandboxmemory');
        } catch (\Exception $e) {
            \Log::critical("ULYS API ERROR", ['Exception' => $e]);
        }
    }
}
