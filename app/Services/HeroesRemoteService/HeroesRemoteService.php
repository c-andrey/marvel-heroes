<?php

namespace App\Services\HeroesRemoteService;

use Illuminate\Support\Facades\Http;

class HeroesRemoteService
{
    public function getHeroes()
    {
        $response = Http::get(env('MARVEL_API_URL') . '/characters', [
            'apikey' =>  env('MARVEL_API_PUBLIC_KEY'),
            'ts' =>  env('MARVEL_API_TIMESTAMP'),
            'hash' =>  env('MARVEL_API_HASHMD5')
        ]);

        if ($response->successful()) {
            return $response->json()['data'];
        }

        return response()->json([
            'data' => null,
            'message' => 'Failed',
        ], 500);
    }
}
