<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Services\MovieAPIService;

class ExampleTest extends TestCase
{
    // public function testGetgMovieDetails()
    // {
    //     // Mock the MovieAPIService
    //     $mockedService = $this->mock(MovieAPIService::class);
    //     $mockedService->shouldReceive('getMovieDetails')->andReturn(['title' => 'Star Wars']);

    //     // Send a GET request to your API endpoint
    //     // $response = $this->get('/api/movies/11');
    //     $response = $this->withSession(['_token' => 'HymYWzv4yYQu7Fi2yg8aO1xHDQpfZKzgBrWmZusz'])->get('/');

    //     $response->assertStatus(200);
    //     $response->assertJson(['title' => 'Star Wars']);
    // }

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $response = $this->get('/login');

        $response->assertStatus(200);
    }
}
