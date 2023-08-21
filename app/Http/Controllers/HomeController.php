<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;


use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\Production;
use App\Models\Genre;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $APP_TMDB_SYNC = env('APP_TMDB_SYNC');
        if ($APP_TMDB_SYNC == 0) {

            $apiKey = env('TMDB_API_KEY');

            $response = Http::get("https://api.themoviedb.org/3/collection/10-star-wars-collection", [
                'api_key' => $apiKey,
            ]);

            $movies = $response->json();

            $i = 0;
            $movie_added = array();
            foreach ($movies['parts'] as $movie) {

                $movies['parts'][$i]['adult'] = (!empty($movie['adult'])) ? 1 : 0;
                $movies['parts'][$i]['genre_ids'] = implode(",", $movie['genre_ids']);
                $movies['parts'][$i]['video'] = (!empty($movie['video'])) ? $movie['video'] : '';

                $movie_new = Movie::find($movie['id']);

                if (empty($movie_new)) {
                    $movie_added[]['new'] = DB::table('movies')->insert($movies['parts'][$i]);


                    $details_response = Http::get("https://api.themoviedb.org/3/movie/" . $movie['id'], [
                        'api_key' => $apiKey,
                    ]);

                    $movie_details = $details_response->json();

                    $pi = 0;
                    $production_ids = array();
                    foreach ($movie_details['production_companies'] as $production) {

                        $production_ids[] = (!empty($production['id'])) ? $production['id'] : '0';

                        $new_production = Production::find($production['id']);

                        if (empty($new_production)) {
                            $production_new[] = DB::table('production')->insert($movie_details['production_companies'][$pi]);
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
                            $genre_new[] = DB::table('genres')->insert($movie_details['genres'][$gi]);
                        }

                        $gi++;
                    }
                }

                $i++;
            }

            $this->setEnv('APP_TMDB_SYNC', '1');

            return redirect()->route('welcome')->with('success', count($movie_added) . ' New Movies added successfully.');
        }

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
            Cache::put($cacheKey, $movies, now()->addMinutes(60));
        }

        return view('home');
    }

    public function show(Request $request, $id)
    {
        $cacheKey = 'db_movie_info';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movie_info = Cache::get($cacheKey);
        } else {

            $movie_info = Movie::find($id);

            // Cache the response for a specific time
            Cache::put($cacheKey, $movie_info, now()->addMinutes(60));
        }

        $genres = Genre::select("*")->whereIn('id', explode(',', $movie_info['genre_ids']))->get();
        $productions = Production::select("*")->whereIn('id', explode(',', $movie_info['production_id']))->get();

        return view(
            'movies.movie',
            [
                'movie' => $movie_info,
                'genres' => (!empty($genres)) ? $genres : array(),
                'productions' => (!empty($productions)) ? $productions : array()
            ]
        );
    }


    public function edit(Request $request, $id)
    {
        // $movie = Movie::where('id', $id)->firstOrFail();
        $movie = Movie::find($id);;
        $genres = Genre::select("*")->get();
        $productions = Production::select("*")->get();

        $selectedID = $request->input('genre_ids');
        $productionID = $request->input('production_id');
        return view(
            'movies.edit',
            [
                'movie' => $movie,
                'genres' => (!empty($genres)) ? $genres : array(),
                'productions' => (!empty($productions)) ? $productions : array(),
                'selectedID' => $selectedID,
                'productionID' => $productionID
            ]
        );
    }

    function setEnv($name, $value)
    {
        $path = base_path('.env');
        if (file_exists($path)) {
            file_put_contents($path, str_replace(
                $name . '=' . env($name),
                $name . '=' . $value,
                file_get_contents($path)
            ));
        }
    }
}
