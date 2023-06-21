<?php

namespace App\Services\HeroesRemoteService;

use Illuminate\Support\Facades\Http;

class HeroesRemoteService
{
    public function getHeroes(array $attributes)
    {
        $params = [
            'apikey' =>  env('MARVEL_API_PUBLIC_KEY'),
            'ts' =>  env('MARVEL_API_TIMESTAMP'),
            'hash' =>  env('MARVEL_API_HASHMD5'),
            ...$attributes
        ];
        $response = Http::get(env('MARVEL_API_URL') . '/characters', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return response()->json([
            'data' => null,
            'message' => 'Failed',
        ], 500);
    }
}
