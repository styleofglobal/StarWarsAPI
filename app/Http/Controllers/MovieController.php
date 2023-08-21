<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Production;
use App\Models\Genre;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
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
            Cache::put($cacheKey, $movies, now()->addMinutes(60));
        }

        // return response()->json($movies, 200);
        return response()->json(array('results' => $movies), 200);
    }

    // public function index()
    // {
    //     $movies = Movie::all();
    //     return response()->json($movies, 200);
    // }


    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $movie = Movie::create($request->all());

        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('success', 'Movie added successfully.');
        } else {
            return response()->json($movie, 200);
        }
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


        return response()->json([
            'movie' => $movie_info,
            'genres' => (!empty($genres)) ? $genres : array(),
            'productions' => (!empty($productions)) ? $productions : array()
        ], 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'status' => 'required',
        ]);

        $movie = Movie::find($id);

        $movie->title = $request->title;
        $movie->original_title = $request->original_title ? $request->original_title : $request->title;
        $movie->original_language = $request->original_language;
        $movie->popularity = $request->popularity;
        $movie->release_date = $request->release_date;
        $movie->vote_average = $request->vote_average;
        $movie->vote_count = $request->vote_count;
        $movie->media_type = $request->media_type;
        $movie->status = $request->status;
        $movie->budget = $request->budget;
        $movie->revenue = $request->revenue;
        $movie->runtime = $request->runtime;
        $movie->video = $request->video ? $request->video : 0;
        $movie->adult = $request->adult ? $request->adult : 0;
        $movie->poster_path = $request->poster_path;
        $movie->backdrop_path = $request->backdrop_path;
        $movie->genre_ids = $request->genre_ids ? implode(",", $request->genre_ids) : '0';
        $movie->production_id = $request->production_id ? implode(",", $request->production_id) : '0';
        $movie->tagline = $request->tagline;
        $movie->overview = $request->overview;

        $movie->save();
        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('success', 'Movie details updated successfully');
        } else {
            return response()->json($movie, 200);
        }
    }

    public function destroy(Request $request, $id)
    {
        Movie::destroy($id);

        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('danger', 'Movie deleted successfully.');
        } else {
            return response()->json(null, 204);
        }
    }


    public function fetchMoviesFromTMDb(Request $request)
    {
        $apiKey = env('TMDB_API_KEY');
        $cacheKey = 'tmdb_movies';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movies = Cache::get($cacheKey);
        } else {
            // $response = Http::get("https://api.themoviedb.org/3/movie/popular", [
            // $response = Http::get("https://api.themoviedb.org/3/list/8136", [ //The Entire Star Wars Collection
            $response = Http::get("https://api.themoviedb.org/3/collection/10-star-wars-collection", [
                'api_key' => $apiKey,
            ]);

            $movies = $response->json();

            // Cache the response for a specific time
            Cache::put($cacheKey, $movies, now()->addMinutes(60));
        }

        // Store $movies in your database or process the data as needed
        return response()->json($movies, 200);
        // return response()->json($movies['parts'], 200);
    }

    public function fetchMovieFromTMDb(Request $request, $id)
    {
        $apiKey = env('TMDB_API_KEY');
        $cacheKey = 'tmdb_movie';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movie_info = Cache::get($cacheKey);
        } else {
            $response = Http::get("https://api.themoviedb.org/3/movie/" . $id, [
                'api_key' => $apiKey,
            ]);

            $movie_info = $response->json();

            // Cache the response for a specific time
            Cache::put($cacheKey, $movie_info, now()->addMinutes(60));
        }

        return response()->json($movie_info, 200);
    }

    public function fetchMoviesFromswapi(Request $request)
    {
        $cacheKey = 'swapi_movies';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movies = Cache::get($cacheKey);

            return response()->json($movies);
        } else {
            $response = Http::get('https://swapi.dev/api/films');

            if ($response->successful()) {

                $movies = $response->json();

                // Cache the response for a specific time
                Cache::put($cacheKey, $movies, now()->addMinutes(60));
                return response()->json($movies);
            } else {
                return response()->json(['message' => 'Failed to fetch Star Wars movies'], 500);
            }
        }
    }
}
