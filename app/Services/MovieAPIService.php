<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

use App\Models\Movie;
use App\Models\Production;
use App\Models\Genre;
use Illuminate\Support\Arr;

class MovieAPIService
{
    protected $apiKey;
    protected $cache_min;

    public function __construct()
    {
        $this->apiKey = env('TMDB_API_KEY');
        $this->cache_min = env('CACHE_MIN');
    }

    public function getMovies($request)
    {
        $search = $request->input('search');

        $query = Movie::query();

        if ($search) {
            $query->where('title', 'LIKE', "%$search%");
        }

        $cacheKey = 'db_movies_data';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movies = Cache::get($cacheKey);
        } else {

            $movies = $query->get();

            // Cache the response for a specific time
            Cache::put($cacheKey, $movies, now()->addMinutes($this->cache_min));
        }

        return $movies;
    }

    public function getMovie($id)
    {
        $cacheKey = 'movie_id_' . $id . '_info';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movie_details = Cache::get($cacheKey);
        } else {
            $movie_info = Movie::find($id);
            $genres = Genre::select("*")->whereIn('id', explode(',', $movie_info['genre_ids']))->get();
            $productions = Production::select("*")->whereIn('id', explode(',', $movie_info['production_id']))->get();

            $movie_details = array(
                'movie' => $movie_info,
                'genres' => (!empty($genres)) ? $genres : array(),
                'productions' => (!empty($productions)) ? $productions : array()
            );

            // Cache the response for a specific time
            Cache::put($cacheKey, $movie_details, now()->addMinutes($this->cache_min));
        }

        return $movie_details;
    }

    public function editMovie($request, $id)
    {
        // $movie = Movie::where('id', $id)->firstOrFail();
        $movie = Movie::find($id);
        $genres = Genre::select("*")->get();
        $productions = Production::select("*")->get();

        $selectedID = $request->input('genre_ids');
        $productionID = $request->input('production_id');

        $movie_edit_details = array(
            'movie' => $movie,
            'genres' => (!empty($genres)) ? $genres : array(),
            'productions' => (!empty($productions)) ? $productions : array(),
            'selectedID' => $selectedID,
            'productionID' => $productionID
        );

        return $movie_edit_details;
    }

    public function updateMovie($request, $id)
    {
        if (!empty($request) && !empty($id)) {

            $movie = Movie::find($id);

            !empty($request->title) ? $movie->title = $request->title : '';
            !empty($request->original_title) ? $movie->original_title = $request->original_title : '';
            !empty($request->original_language) ? $movie->original_language = $request->original_language : '';
            !empty($request->popularity) ? $movie->popularity = $request->popularity : '';
            !empty($request->release_date) ? $movie->release_date = $request->release_date : '';
            !empty($request->vote_average) ? $movie->vote_average = $request->vote_average : '';
            !empty($request->vote_count) ? $movie->vote_count = $request->vote_count : '';
            !empty($request->media_type) ? $movie->media_type = $request->media_type : '';
            !empty($request->status) ? $movie->status = $request->status : '';
            !empty($request->budget) ? $movie->budget = $request->budget : '';
            !empty($request->revenue) ? $movie->revenue = $request->revenue : '';
            !empty($request->runtime) ? $movie->runtime = $request->runtime : '';
            !empty($request->video) ? $movie->video = $request->video : '';
            !empty($request->adult) ? $movie->adult = $request->adult : '';
            !empty($request->poster_path) ? $movie->poster_path = $request->poster_path : '';
            !empty($request->backdrop_path) ? $movie->backdrop_path = $request->backdrop_path : '';
            !empty($request->genre_ids) ? implode(",", $request->genre_ids) : '';
            !empty($request->production_id) ? implode(",", $request->production_id) : '';
            !empty($request->tagline) ? $movie->tagline = $request->tagline : '';
            !empty($request->overview) ? $movie->overview = $request->overview : '';

            return $movie->save();
        } else {

            return null; // Handle error
        }
    }

    public function createMovie($request)
    {
        $id =  Movie::create($request->all());
        if (!empty($id)) {
            return $id;
        } else {

            return null; // Handle error
        }
    }

    public function deleteMovie($id)
    {
        if (!empty($id)) {
            return Movie::destroy($id);
        } else {

            return null; // Handle error
        }
    }

    public function getTMDBMovies()
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

    public function getTMDBMovie($movieId)
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
