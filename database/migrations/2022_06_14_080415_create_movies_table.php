<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMoviesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movies', function (Blueprint $table) {
            $table->id();
            $table->string('adult')->default(0);
            $table->string('backdrop_path')->default('');
            $table->string('title');
            $table->string('original_language')->default(0);
            $table->string('original_title')->default(0);
            $table->text('overview');
            $table->string('poster_path')->default(0);
            $table->string('media_type')->default(0);
            $table->string('genre_ids')->default(0);
            $table->string('popularity');
            $table->date('release_date');
            $table->string('video')->default(0);
            $table->integer('vote_average')->default(0);
            $table->string('vote_count')->default(0);
            $table->string('budget')->default(0);
            $table->string('tagline')->default(0);
            $table->string('status')->default(0);
            $table->string('runtime')->default(0);
            $table->string('revenue')->default(0);
            $table->string('production_id')->default(0);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->nullable()->useCurrentOnUpdate();
            $table->timestamp('deleted_at')->nullable();

            // $table->foreign('production_id')->references('id')->on('production');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movies');
    }
}
