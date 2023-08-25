<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Services\MovieAPIService;

class MovieControllerTest extends TestCase
{
    public function testFetchingMovieDetails()
    {
        // Mock the HTTP request to the TMDB API
        // $mockedResponse = json_encode(['title' => 'Star Wars', 'director' => 'George Lucas']);
        $mockedResponse = json_encode(['title' => 'Star Wars']);
        $this->mockHttpClient($mockedResponse);

        $tmdbService = app(MovieAPIService::class);
        $movieDetails = $tmdbService->getMovie(11);

        $this->assertEquals('Star Wars', $movieDetails['title']);
        // $this->assertEquals('George Lucas', $movieDetails['director']);
    }

    // Helper function to mock the HTTP client
    protected function mockHttpClient($response)
    {
        $http = $this->mock(\GuzzleHttp\Client::class);
        $http->shouldReceive('get')->andReturn($response);
        $this->app->instance(\GuzzleHttp\Client::class, $http);
    }


    // assertTrue()
    // assertFalse()
    // assertEquals()
    // assertNull()
    // assertContains()
    // assertCount()
    // assertEmpty()

}
