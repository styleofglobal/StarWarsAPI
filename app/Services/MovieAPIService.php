<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\Movie;
use App\Models\Production;
use App\Models\Genre;

class MovieAPIService
{
    protected $apiKey;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
    }

    public function getMovies()
    {
        $cacheKey = 'tmdb_movies';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            // $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            // $response = Http::get("https://api.themoviedb.org/3/list/8136", [ //The Entire Star Wars Collection
            $response = Http::get("https://api.themoviedb.org/3/collection/10-star-wars-collection", [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {

                // Cache the response for a specific time
                Cache::put($cacheKey, $response->json(), now()->addMinutes(60));


                return $response->json();
            }

            return null; // Handle error
        }
    }

    public function getMovie($movieId)
    {
        $cacheKey = 'tmdb_movie_' . $movieId;

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {

            $response = Http::get("https://api.themoviedb.org/3/movie/{$movieId}", [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                // Cache the response for a specific time
                Cache::put($cacheKey, $response->json(), now()->addMinutes(60));

                return $response->json();
            }

            return null; // Handle error
        }
    }

    public function syncMovies()
    {
        $movies = "";
        $cacheKey = 'tmdb_movies';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movies = Cache::get($cacheKey);
        } else {
            $response = Http::get("https://api.themoviedb.org/3/collection/10-star-wars-collection", [
                'api_key' => $this->apiKey,
            ]);

            if ($response->successful()) {
                // Cache the response for a specific time
                Cache::put($cacheKey, $response->json(), now()->addMinutes(60));

                $movies = $response->json();
            } else {
                return null; // Handle error
            }
        }

        if (!empty($movies)) {

            $i = 0;
            $movie_added = array();
            foreach ($movies['parts'] as $movie) {

                $movies['parts'][$i]['adult'] = (!empty($movie['adult'])) ? 1 : 0;
                $movies['parts'][$i]['genre_ids'] = implode(",", $movie['genre_ids']);
                $movies['parts'][$i]['video'] = (!empty($movie['video'])) ? $movie['video'] : '';

                $movie_new = Movie::find($movie['id']);

                if (empty($movie_new)) {
                    $movie_added[]['new'] = Movie::create($movies['parts'][$i]);
                    // $movie_added[]['new'] = DB::table('movies')->insert($movies['parts'][$i]);


                    $details_response = Http::get("https://api.themoviedb.org/3/movie/" . $movie['id'], [
                        'api_key' => $this->apiKey,
                    ]);

                    $movie_details = $details_response->json();

                    $pi = 0;
                    $production_ids = array();
                    foreach ($movie_details['production_companies'] as $production) {

                        $production_ids[] = (!empty($production['id'])) ? $production['id'] : '0';

                        $new_production = Production::find($production['id']);

                        if (empty($new_production)) {
                            $production_new[] = Production::create($movie_details['production_companies'][$pi]);
                            // $production_new[] = DB::table('production')->insert($movie_details['production_companies'][$pi]);
                        }

                        $pi++;
                    }

                    $update_movie = Movie::find($movie_details['id']);
                    $update_movie->budget = $movie_details['budget'] ? $movie_details['budget'] : '';
                    $update_movie->tagline = $movie_details['tagline'] ? $movie_details['tagline'] : '';
                    $update_movie->status = $movie_details['status'] ? $movie_details['status'] : '';
                    $update_movie->runtime = $movie_details['runtime'] ? $movie_details['runtime'] : 0;
                    $update_movie->revenue = $movie_details['revenue'] ? $movie_details['revenue'] : 0;
                    $update_movie->production_id = implode(",", $production_ids);
                    $update_movie->save();

                    $gi = 0;
                    foreach ($movie_details['genres'] as $genre) {

                        $is_genre = Genre::find($genre['id']);

                        if (empty($is_genre)) {
                            $genre_new[] = Genre::create($movie_details['genres'][$gi]);
                            // $genre_new[] = DB::table('genres')->insert($movie_details['genres'][$gi]);
                        }

                        $gi++;
                    }
                }

                $i++;
            }
            return $movie_added;
        } else {
            return null; // Handle error
        }
    }

    public function swapiMovies()
    {
        $cacheKey = 'swapi_movies';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $response = Http::get('https://swapi.dev/api/films');

            if ($response->successful()) {

                // Cache the response for a specific time
                Cache::put($cacheKey, $response->json(), now()->addMinutes(60));

                return $response->json();
            } else {
                return null; // Handle error
            }
        }
    }
}
