@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <a href="{{route('episode.index')}}" class="btn btn-primary">List Episode</a>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Movie") }}
                </div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(isset($episode))
                    <form action="{{ route('episode.update', $episode->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @else 
                    <form action="{{ route('episode.store') }}" method="POST" enctype="multipart/form-data"> 
                @endif
                        @csrf
                        
                        <div class="mb-4">
                            <label for="movie" class="block">Chọn Phim:</label>
                            <select type="text" id="movie_id" name="movie_id" class="form-control w-full select-movie">
                                <option value="0" {{ isset($movie) && $movie->status == 0 ? 'selected' : '' }}>Chọn Phim</option>
                                @foreach($list_movie as $id => $name)
                                <option value="{{$id}}" {{ isset($episode) && $episode->movie_id == $id ? 'selected' : '' }}>{{$name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="link" class="block">Link Phim:</label>
                            <input type="text"  name="link" class="form-control w-full" value="{{ isset($episode) ? $episode->linkmovie : '' }}">
                        </div>
                        @if(isset($episode))
                        <div class="mb-4">
                            <label for="episode" class="block">Tập Phim:</label>
                            <input type="text" name="episode" {{ isset($episode) ? 'readonly' : '' }} class="form-control w-full" value="{{ isset($episode) ? $episode->episode : '' }}">
                        </div>
                        @else
                        <div class="mb-4">
                            <label for="episode" class="block">Tập Phim:</label>
                            <select type="text" id="show_movie" name="episode" class="form-control w-full"> 
                                
                            </select>
                        </div>
                        @endif
                        <div class="mb-4">
                            <label for="linkserver" class="block">Link Server:</label>
                            <select name="linkserver" class="form-control w-full">
                                @foreach($linkmovie as $id => $name)
                                    <option value="{{ $id }}" {{ isset($episode) && $episode->server == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        
                        {{-- Button Submit --}}
                        @if(!isset($episode))
                        <button type="submit" class="btn btn-primary btn-success">Thêm tập phim</button>
                        @else
                        <button type="submit" class="btn btn-primary btn-success">Cập nhật tập phim</button>
                        @endif
                    </form>
                </div>
                
                
            </div>
            
        </div>
    </div>
</div>

@endsection
