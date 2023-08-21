@extends('layouts.app')

@section('content')

<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<!-- select2 -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />

<!-- select2-bootstrap4-theme -->
<link href="https://raw.githack.com/ttskch/select2-bootstrap4-theme/master/dist/select2-bootstrap4.css" rel="stylesheet"> <!-- for live demo page -->
<link href="select2-bootstrap4.css" rel="stylesheet"> <!-- for local development env -->

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">{{ __('Edit Movie') }}</div>

                <div class="card-body">
                    @if (session('message'))
                    <div class="alert alert-success" role="alert">
                        {{ session('message') }}
                    </div>
                    @endif

                    <form method="POST" action='{{ route("movies.update", $movie->id) }}' enctype="multipart/form-data">
                        @csrf
                        @method('PATCH')
                        <input type="hidden" name="fromweb" value=1 required>

                        <div class="row">
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="title">Title</label>
                                <input class="form-control" type="text" name="title" placeholder="Title" value="{{$movie->title}}" required autocomplete="title" autofocus>
                                @error('title')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            @if($movie->title != $movie->original_title)
                            <div class="form-group col-lg-6 col-md-12">
                                <label for="original_title">Original Title</label>
                                <input class="form-control" type="text" name="original_title" placeholder="original title" value="{{$movie->original_title}}" required autocomplete="original_title" autofocus>
                                @error('original_title')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            @endif
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="original_language">Language</label>
                                <input class="form-control" type="text" name="original_language" placeholder="original_language" value="{{$movie->original_language}}" required autocomplete="original_language" autofocus>
                                @error('original_language')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="popularity">Popularity</label>
                                <input class="form-control" type="text" name="popularity" placeholder="popularity" value="{{$movie->popularity}}" required autocomplete="popularity" autofocus>
                                @error('popularity')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="release_date">Release Date</label>
                                <input class="form-control" type="text" name="release_date" placeholder="release_date" value="{{$movie->release_date}}" required autocomplete="release_date" autofocus>
                                @error('release_date')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="vote_average">Vote Average</label>
                                <input class="form-control" type="text" name="vote_average" placeholder="vote_average" value="{{$movie->vote_average}}" required autocomplete="vote_average" autofocus>
                                @error('vote_average')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="vote_count">Vote Count</label>
                                <input class="form-control" type="text" name="vote_count" placeholder="vote_count" value="{{$movie->vote_count}}" required autocomplete="vote_count" autofocus>
                                @error('vote_count')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="media_type">Media Type</label>
                                <input class="form-control" type="text" name="media_type" placeholder="media_type" value="{{$movie->media_type}}" required autocomplete="media_type" autofocus>
                                @error('media_type')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="status">Status</label>
                                <input class="form-control" type="text" name="status" placeholder="status" value="{{$movie->status}}" autocomplete="status" autofocus>
                                @error('status')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="budget">Budget</label>
                                <input class="form-control" type="text" name="budget" placeholder="budget" value="{{$movie->budget}}" autocomplete="budget" autofocus>
                                @error('budget')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="revenue">Revenue</label>
                                <input class="form-control" type="text" name="revenue" placeholder="revenue" value="{{$movie->revenue}}" autocomplete="revenue" autofocus>
                                @error('revenue')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="runtime">Runtime</label>
                                <input class="form-control" type="text" name="runtime" placeholder="runtime" value="{{$movie->runtime}}" required autocomplete="runtime" autofocus>
                                @error('runtime')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="video">Video</label>
                                <input class="form-control" type="text" name="video" placeholder="video" value="{{$movie->video ? $movie->video : 0}}" autocomplete="video" autofocus>
                                @error('video')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                            <div class="form-group col-lg-4 col-md-12">
                                <label for="adult">Adult</label>
                                <input class="form-control" type="text" name="adult" placeholder="adult" value="{{$movie->adult}}" autocomplete="adult" autofocus>
                                @error('adult')
                                <label class="text-danger">{{ $message }}</label>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="poster_path">TMDB Poster Path</label>
                                    <input class="form-control" type="text" name="poster_path" placeholder="poster_path" value="{{$movie->poster_path}}" required autocomplete="poster_path" autofocus>
                                    @error('poster_path')
                                    <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="backdrop_path">TMDB Backdrop Path</label>
                                    <input class="form-control" type="text" name="backdrop_path" placeholder="backdrop_path" value="{{$movie->backdrop_path}}" required autocomplete="backdrop_path" autofocus>
                                    @error('backdrop_path')
                                    <label class="text-danger">{{ $message }}</label>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label id="genre_ids">Genres</label>
                                    <select multiple placeholder="Choose here" data-allow-clear="1" name="genre_ids[]">
                                        <option>Select Genres</option>
                                        @foreach ($genres as $key => $value)
                                        <option {{ in_array($value->id,explode(',', $movie->genre_ids)) ? 'selected' : '' }} value={{ $value->id }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label name="production_id">Production Company</label>
                                    <select multiple placeholder="Choose here" data-allow-clear="1" name="production_id[]">
                                        <option>Select Production Company</option>
                                        @foreach ($productions as $key => $value)
                                        <!-- <option {{ in_array($value->id,explode(',', $movie->production_id)) ? 'selected' : '' }} value={{ $value->id }}>{{ $value->name }}</option> -->
                                        <option value="{{ $value->id }}" {{ (in_array($value->id,explode(',', $movie->production_id))) ? 'selected' : '' }}>{{ $value->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="form-group col-md-12 m-t-5">
                            <label for="tagline">Tagline</label>
                            <textarea name="tagline" placeholder="tagline" class="form-control" rows="3" minlength="7" required>{{$movie->tagline}}</textarea>
                            @error('tagline')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>
                        <div class="form-group col-md-12 m-t-5">
                            <label for="overview">Overview</label>
                            <textarea name="overview" placeholder="overview" class="form-control" rows="3" minlength="7" required>{{$movie->overview}}</textarea>
                            @error('overview')
                            <label class="text-danger">{{ $message }}</label>
                            @enderror
                        </div>

                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <a class="btn btn-danger mr-1" href='{{ route("home") }}' type="submit">Cancel</a>
                                <button class="btn btn-success" type="submit">Save</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<script>
    $(function() {
        $('select').each(function() {
            $(this).select2({
                theme: 'bootstrap4',
                width: 'style',
                placeholder: $(this).attr('placeholder'),
                allowClear: Boolean($(this).data('allow-clear')),
            });
        });
    });
</script>
@endsection
