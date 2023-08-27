<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Production extends Model
{
    use HasFactory;

    // protected $fillable = ['title', 'director', 'release_year'];
    protected $guarded = [];
    protected $table = "production";

    // Define relationships and methods here
    /**
     * Get the post that owns the comment.
     */

    // public function movie()
    // {

    //     return $this->belongsTo(Movie::class);
    // }
}
