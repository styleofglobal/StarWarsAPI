<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use App\Models\Production;
use App\Models\Genre;
use Illuminate\Http\Request;

use App\Services\MovieAPIService;

use Illuminate\Support\Facades\Cache;

class MovieController extends Controller
{
    protected $movieAPIService;
    protected $cache_min;

    public function __construct(MovieAPIService $movieAPIService)
    {
        $this->movieAPIService = $movieAPIService;
        $this->cache_min = env('CACHE_MIN');
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
            Cache::put($cacheKey, $movies, now()->addMinutes($this->cache_min));
        }

        // return response()->json($movies, 200);
        return response()->json(array('results' => $movies), 200);
    }

    // public function index2(Request $request)
    // {
    //     // $movies = Movie::all();
    //     $search = $request->input('search');

    //     $query = Movie::query();

    //     if ($search) {
    //         $query->where('title', 'LIKE', "%$search%");
    //     }

    //     $cacheKey = 'db_movies_data';

    //     // Check if the data is cached
    //     if (Cache::has($cacheKey)) {
    //         $movies = Cache::get($cacheKey);
    //     } else {

    //         $movies = $query->get();

    //         // Cache the response for a specific time
    //         Cache::put($cacheKey, $movies, now()->addMinutes($this->cache_min));
    //     }
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
        $cacheKey = 'movie_id_' . $id . '_info';

        // Check if the data is cached
        if (Cache::has($cacheKey)) {
            $movie_details = Cache::get($cacheKey);
        } else {
            $movie_info = Movie::find($id);
            $genres = Genre::select("*")->whereIn('id', explode(',', $movie_info['genre_ids']))->get();
            $productions = Production::select("*")->whereIn('id', explode(',', $movie_info['production_id']))->get();

            $movie_details = [
                'movie' => $movie_info,
                'genres' => (!empty($genres)) ? $genres : array(),
                'productions' => (!empty($productions)) ? $productions : array()
            ];

            // Cache the response for a specific time
            Cache::put($cacheKey, $movie_details, now()->addMinutes($this->cache_min));
        }

        return response()->json($movie_details, 200);
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'overview' => 'required',
        ]);

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

        $movie->save();
        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('success', 'Movie details updated successfully');
        } else {
            return response()->json($movie, 200);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     $movie = Movie::findOrFail($id);
    //     $movie->update($request->all());

    //     return response()->json($movie, 200);
    // }

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
        $movies = $this->movieAPIService->getMovies();

        // Store $movies in your database or process the data as needed
        return response()->json($movies, 200);
        // return response()->json($movies['parts'], 200);
    }

    public function fetchMovieFromTMDb(Request $request, $id)
    {
        $movie_info = $this->movieAPIService->getMovie($id);

        return response()->json($movie_info, 200);
    }

    public function fetchMoviesFromswapi(Request $request)
    {
        $movies = $this->movieAPIService->swapiMovies();

        if ($movies) {
            return response()->json($movies);
        } else {
            return response()->json(['message' => 'Failed to fetch Star Wars movies'], 500);
        }
    }
}
