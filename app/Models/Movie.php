<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'original_title', 'original_language', 'popularity', 'release_date', 'vote_average', 'vote_count', 'media_type', 'status', 'budget', 'revenue', 'runtime', 'video', 'adult', 'poster_path', 'backdrop_path', 'genre_ids', 'production_id', 'tagline', 'overview'];

    // Define relationships and methods here

    // /**
    //  * Get the movies for the movie
    //  */
    // public function genres()
    // {

    //     return $this->hasMany(Genre::class);
    // }

    // /**
    //  * Get the movies for the movie
    //  */
    // public function production()
    // {
    //     return $this->hasMany(Production::class);
    // }
}
