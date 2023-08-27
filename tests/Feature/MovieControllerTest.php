<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\MovieAPIService;
use App\Models\Movie;

class MovieControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    // Test fetching movie details from TMDB API
    public function testFetchingMovieDetailsFromTMDB($id = "11")
    {
        $moviesApiService = app(MovieAPIService::class);
        $movieDetails = $moviesApiService->getTMDBMovie($id);

        $this->assertEquals('Star Wars', $movieDetails['title']);
    }

    // Test listing movies through TMDB API
    public function testListingMoviesFromTMDB()
    {
        $moviesApiService = app(MovieAPIService::class);
        $movies = $moviesApiService->getTMDBMovies();

        $this->assertCount(count($movies), $movies);
    }

    // Test listing movies from database
    public function testListingMovies()
    {
        $moviesApiService = app(MovieAPIService::class);
        $movies = $moviesApiService->getTMDBMovies();

        $this->assertCount(count($movies), $movies);
    }

    // Test Create a movies record in the database
    public function testCreateMovies()
    {
        // Create a few movie records in the database using factory
        $movies = Movie::factory(3)->create();

        $this->assertCount(count($movies), $movies);
    }

    public function testUpdatingMovie()
    {
        // Create a movie record in the database
        $movie = Movie::factory()->create();

        // Define the updated attributes
        $updatedAttributes = [
            'title' => 'Updated Movie Title',
            'overview' => 'Updated Overview',
        ];

        // Send a PATCH request to update the movie
        $response = $this->patchJson("/api/movies/{$movie->id}", $updatedAttributes);

        // Assert response status and content
        $response->assertStatus(200);

        // Refresh the movie model from the database to get the updated attributes
        $movie->refresh();

        // Assert the updated attributes match the attributes in the database
        $this->assertEquals($updatedAttributes['title'], $movie->title);
        $this->assertEquals($updatedAttributes['overview'], $movie->overview);
    }

    public function testDeletingMovie()
    {
        // Create a movie record in the database
        $movie = Movie::factory()->create();

        // Send a DELETE request to delete the movie
        $response = $this->deleteJson("/api/movies/{$movie->id}");

        // Assert response status and content
        $response->assertStatus(204);
        $this->assertDatabaseMissing('movies', ['id' => $movie->id]);
    }

    // // Test fetching movies from SWAPI
    // public function testFetchingMoviesFromSWAPI()
    // {
    //     // $moviesApiService = app(MovieAPIService::class);
    //     // $response = $moviesApiService->swapiMovies();

    //     $response = $this->get('https://swapi.dev/api/films');

    //     $response->assertStatus(200);
    //     $response->assertJsonStructure([
    //         'results' => [
    //             '*' => [
    //                 'title',
    //                 'director',
    //                 'release_date',
    //                 // Other expected fields
    //             ],
    //         ],
    //     ]);
    // }

    // public function testFetchingMovieDetails()
    // {
    //     // Mock the HTTP request to the TMDB API
    //     // $mockedResponse = json_encode(['title' => 'Star Wars']);
    //     // $this->mockHttpClient($mockedResponse);

    //     $moviesApiService = app(MovieAPIService::class);
    //     $movieDetails = $moviesApiService->getMovie(11);

    //     $this->assertEquals('Star Wars', $movieDetails['title']);
    // }

    // // Helper function to mock the HTTP client
    // protected function mockHttpClient($response)
    // {
    //     $http = $this->mock(\GuzzleHttp\Client::class);
    //     $http->shouldReceive('get')->andReturn($response);
    //     $this->app->instance(\GuzzleHttp\Client::class, $http);
    // }

    // assertTrue()
    // assertFalse()
    // assertEquals()
    // assertNull()
    // assertContains()
    // assertCount()
    // assertEmpty()

}
