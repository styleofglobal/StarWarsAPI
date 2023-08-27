<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class MovieFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Movie::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'adult' => false,
            'backdrop_path' => '/zqkmTXzjkAgXmEWLRsY4UpTWCeo.jpg',
            'title' => $this->faker->title,
            'original_language' => $this->faker->languageCode,
            'original_title' => $this->faker->title,
            'overview' => $this->faker->sentence,
            'poster_path' => '/6FfCtAuVAW8XJjZ7eWeLibRLWTw.jpg',
            'media_type' => $this->faker->name,
            'genre_ids' => '0',
            'popularity' => '44',
            'release_date' => date('Y-m-d'),
            'video' => false,
            'vote_average' => '4.4',
            'vote_count' => '444',
            'budget' => '38400000',
            'tagline' => $this->faker->sentence,
            'status' => $this->faker->name,
            'runtime' => '44',
            'revenue' => '538400000',
            'production_id' => 1
        ];
    }
}
