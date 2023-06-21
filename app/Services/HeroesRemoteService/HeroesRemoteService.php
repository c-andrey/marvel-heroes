<?php

namespace App\Services\HeroesRemoteService;

use Illuminate\Support\Facades\Http;

class HeroesRemoteService
{
    public function getHeroes(array $attributes)
    {
        $perPage = isset($attributes['perPage']) ? (int) $attributes['perPage'] : 10;

        $params = [
            'apikey' =>  env('MARVEL_API_PUBLIC_KEY'),
            'ts' =>  env('MARVEL_API_TIMESTAMP'),
            'hash' =>  env('MARVEL_API_HASHMD5'),
            'limit' => $perPage
        ];

        if (isset($attributes['name'])) {
            $params['name'] = $attributes['name'];
        }

        if (isset($attributes['page'])) {
            $params['offset'] = ((int) $attributes['page'] - 1) * $perPage;
        }

        $response = Http::get(env('MARVEL_API_URL') . '/characters', $params);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return response()->json([
            'data' => null,
            'message' => $response->json()['status'] ?? 'Error getting heroes from Marvel API',
        ], $response->status());
    }
}
