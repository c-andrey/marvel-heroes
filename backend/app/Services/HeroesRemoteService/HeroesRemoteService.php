<?php

namespace App\Services\HeroesRemoteService;

use Exception;
use Illuminate\Support\Facades\Http;

class HeroesRemoteService
{
    public function getHeroes(array $attributes)
    {
        $perPage = isset($attributes['perPage']) ? (int) $attributes['perPage'] : 10;
        $page = isset($attributes['page']) ? (int) $attributes['page'] : 1;

        $params = [
            'apikey' =>  env('MARVEL_API_PUBLIC_KEY'),
            'ts' =>  env('MARVEL_API_TIMESTAMP'),
            'hash' =>  env('MARVEL_API_HASHMD5'),
            'limit' => $perPage
        ];

        if (isset($attributes['name'])) {
            $params['name'] = $attributes['name'];
        }

        $params['offset'] = ((int) $page - 1) * $perPage;

        $response = Http::get(env('MARVEL_API_URL') . '/characters', $params);

        if ($response->getStatusCode() === 200) {
            return $response->json()['data'];
        } else {
            throw new Exception(isset($response->json()['status']) ? $response->json()['status'] : 'Error getting heroes from Marvel API', $response->getStatusCode());
        }
    }
}
