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
        $movies = $this->movieAPIService->getMovies($request);

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

    public function show(Request $request, $id)
    {
        $movie_details = $this->movieAPIService->getMovie($id);

        return response()->json($movie_details, 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'overview' => 'required',
        ]);

        $movie = $this->movieAPIService->createMovie($request);

        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('success', 'Movie added successfully.');
        } else {
            return response()->json($movie, 200);
        }
    }

    public function update(Request $request, $id)
    {
        // dd($request->all());
        $request->validate([
            'title' => 'required',
            'overview' => 'required',
        ]);

        $movie = $this->movieAPIService->updateMovie($request, $id);

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
        $movie = $this->movieAPIService->deleteMovie($id);

        if (!empty($request->fromweb)) {
            return redirect()->route('home')->with('danger', 'Movie deleted successfully.');
        } else {
            return response()->json(null, 204);
        }
    }

    public function fetchMoviesFromTMDb(Request $request)
    {
        $movies = $this->movieAPIService->getTMDbMovies();

        // Store $movies in your database or process the data as needed
        return response()->json($movies, 200);
        // return response()->json($movies['parts'], 200);
    }

    public function fetchMovieFromTMDb(Request $request, $id)
    {
        $movie_info = $this->movieAPIService->getTMDbMovie($id);

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
