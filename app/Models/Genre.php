<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{
    use HasFactory;

    // protected $fillable = ['name'];
    protected $guarded = [];
    // Define relationships and methods here
    /**
     * Get the post that owns the comment.
     */

    // public function movie()
    // {

    //     return $this->belongsTo(Movie::class);
    // }
}
