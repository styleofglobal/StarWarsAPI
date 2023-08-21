@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="row">
                <div class="col-lg-12 margin-tb">
                    <div class="d-flex justify-content-between">
                        <div>
                            <h2>Movies - modify & delete</h2>
                        </div>
                        <div>
                            Smallworld PHP Job Position Test
                            {{-- <a class="btn btn-success" href="#"> Create New movie</a> --}}
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-12 margin-tb">
                <div class="card">
                    <div class="card-header">{{ __('Dashboard') }}</div>
                    {{-- @if ($message = Session::get('success'))
                        <div class="alert alert-success">
                            <p>{{ $message }}</p>
                        </div>
                    @endif --}}

                    @if (session('success'))
                        <div class="alert alert-success" role="alert">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table class="table table-bordered">
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Details</th>
                            <th width="280px">Action</th>
                        </tr>
                        @foreach ($movies as $movie)
                            <tr>
                                <td>{{ ++$i }}</td>
                                <td>{{ $movie->title }}</td>
                                <td>{{ $movie->overview }}</td>
                                <td>
                                    <form action="{{ route('movies.destroy', $movie->id) }}" method="POST">
                                        {{-- <a class="btn btn-info" href="{{ route('movies.show', $movie->id) }}">Show</a> --}}
                                        <a class="btn btn-primary" href="{{ route('movies.edit', $movie->id) }}">Edit</a>
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                    {{-- {!! $movies->links() !!} --}}

                </div>
            </div>
        </div>
    </div>
@endsection
