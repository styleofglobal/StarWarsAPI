<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MovieAPIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
    }
    
    public function getMovieDetails($movieId)
    {
        return Cache::remember('movie_' . $movieId, now()->addMinutes(30), function () use ($movieId) {
            $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
                'api_key' => $this->apiKey,
            ]);
            
            if ($response->successful()) {
                return $response->json();
            }
    
            return null; // Handle error

            // return $response->json();
        });
    }

    public function getMovie($movieId)
    {
        $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
            'api_key' => $this->apiKey,
        ]);

        if ($response->successful()) {
            return $response->json();
        }

        return null; // Handle error
    }
}
