<?php

namespace App\Services;

use App\Contracts\PerscomApiServiceContract;
use App\Models\Setting;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Request;

class PerscomApiService implements PerscomApiServiceContract
{
    /**
     * @throws \Exception
     */
    public function api(string $endpoint, string $method = Request::METHOD_GET, ?array $data = [])
    {
        $token = Setting::query()->where('key', 'api_key')->pluck('value')->first();
        $id = Setting::query()->where('key', 'perscom_id')->pluck('value')->first();

        $request = Http::baseUrl(config('perscom.url'))->acceptJson()->withToken($token)->withHeaders([
            'X-Perscom-Id' => $id,
            'X-Perscom-Cli' => true,
        ]);

        if (collect($data)->isNotEmpty()) {
            $body = json_encode($data);
            $request->withBody($body);
        }

        Log::debug('perscom_api_request', [
            'url' => config('perscom.url'),
            'headers' => $request->getOptions(),
            'body' => $data,
        ]);

        $response = $request->send($method, $endpoint);

        Log::debug('perscom_api_response', [
            'status' => $response->status(),
            'response' => $response->json(),
        ]);

        return $response;
    }
}
