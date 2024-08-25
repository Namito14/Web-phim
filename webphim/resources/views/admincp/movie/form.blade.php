@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
            <a href="{{route('movie.index')}}" class="btn btn-primary">List Movie</a>
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
                @if(isset($movie))
                    <form action="{{ route('movie.update', $movie->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @else 
                    <form action="{{ route('movie.store') }}" method="POST" enctype="multipart/form-data"> 
                @endif
                        @csrf
                        
                        <div class="mb-4">
                            <label for="title" class="block">Title:</label>
                            <input onkeyup="ChangeToSlug()" type="text" id="slug" name="title" class="form-control w-full" value="{{ isset($movie) ? $movie->title : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="sotap" class="block">Số tập phim:</label>
                            <input type="text" name="sotap" class="form-control w-full" value="{{ isset($movie) ? $movie->sotap : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="time" class="block">Time:</label>
                            <input type="text"  name="time" class="form-control w-full" value="{{ isset($movie) ? $movie->time : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="english_title" class="block">English Title:</label>
                            <input type="text" name="name_eng" class="form-control w-full" value="{{ isset($movie) ? $movie->name_eng : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="trailer" class="block">Trailer:</label>
                            <input type="text" name="trailer" class="form-control w-full" value="{{ isset($movie) ? $movie->trailer : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="slug" class="block">Slug:</label>
                            <input type="slug" id="convert_slug" name="slug" class="form-control w-full" value="{{ isset($movie) ? $movie->slug : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block">Description:</label>
                            <textarea id="myTextarea" style="resize: none;" id="description" name="description" class="form-control w-full">
                            {{ isset($movie) ? $movie->description : '' }}
                            </textarea>
                        </div>
                        <!-- <div class="mb-4">
                            <label for="tags" class="block">Tags phim:</label>
                            <textarea id="myTextarea" style="resize: none;" name="tags" class="form-control w-full">
                            {{ isset($movie) ? $movie->tags : '' }}
                            </textarea>
                        </div> -->
                        <div class="mb-4">
                            <label for="active" class="block">Active:</label>
                            <select type="text" id="status" name="status" class="form-control w-full">
                                <option value="1" {{ isset($movie) && $movie->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ isset($movie) && $movie->status == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="resolution" class="block">Độ phân giải:</label>
                            <select type="text" id="resolution" name="resolution" class="form-control w-full">
                                <option value="0" {{ isset($movie) && $movie->resolution == 0 ? 'selected' : '' }}>HD</option>
                                <option value="1" {{ isset($movie) && $movie->resolution == 1 ? 'selected' : '' }}>SD</option>
                                <option value="2" {{ isset($movie) && $movie->resolution == 2 ? 'selected' : '' }}>HDCam</option>
                                <option value="3" {{ isset($movie) && $movie->resolution == 3 ? 'selected' : '' }}>Cam</option>
                                <option value="4" {{ isset($movie) && $movie->resolution == 4 ? 'selected' : '' }}>FullHD</option>
                                <option value="5" {{ isset($movie) && $movie->resolution == 5 ? 'selected' : '' }}>Trailer</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="subtitle" class="block">Phụ đề:</label>
                            <select type="text" id="subtitle" name="subtitle" class="form-control w-full">
                                <option value="0" {{ isset($movie) && $movie->subtitle == 0 ? 'selected' : '' }}>Vietsub</option>
                                <option value="1" {{ isset($movie) && $movie->subtitle == 1 ? 'selected' : '' }}>Thuyết minh</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="hot" class="block">Phim Hot:</label>
                            <select type="text" id="phim_hot" name="phim_hot" class="form-control w-full">
                                <option value="1" {{ isset($movie) && $movie->phim_hot == 1 ? 'selected' : '' }}>Có</option>
                                <option value="0" {{ isset($movie) && $movie->phim_hot == 0 ? 'selected' : '' }}>Không</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="category" class="block">Category:</label>
                            <select id="category" name="category_id" class="form-control w-full">
                                @foreach($category as $id => $name)
                                    <option value="{{ $id }}" {{ isset($movie) && $movie->category_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="genre" class="block">Genre:</label>
                            <!-- <select id="genre" name="genre_id" class="form-control w-full">
                                @foreach($genre as $id => $name)
                                    <option value="{{ $id }}" {{ isset($movie) && $movie->genre_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select> -->
                            @foreach($list_genre as $key => $gen) 
                                @if(isset($movie))
                            <input type="checkbox" id="{{$gen->id}}" name="genre[]" value="{{$gen->id}}" {{ isset($movie_genre) && $movie_genre->contains($gen->id) ? 'checked' : '' }}>
                                @else 
                            <input type="checkbox" id="{{$gen->id}}" name="genre[]" value="{{$gen->id}}">
                                @endif
                            <label for="genre">{{ $gen->title }}</label><br>
                            @endforeach
                        </div>
                        <div class="mb-4">
                            <label for="country" class="block">Country:</label>
                            <select id="country" name="country_id" class="form-control w-full">
                                @foreach($country as $id => $name)
                                    <option value="{{ $id }}" {{ isset($movie) && $movie->country_id == $id ? 'selected' : '' }}>
                                        {{ $name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block">Image:</label>
                            <input type="file" name="image" class="form-control w-full">
                        </div>
                        
                        {{-- Button Submit --}}
                        @if(!isset($movie))
                        <button type="submit" class="btn btn-primary btn-success">Thêm dữ liệu</button>
                        @else
                        <button type="submit" class="btn btn-primary btn-success">Cập nhật dữ liệu</button>
                        @endif
                    </form>
                </div>
                
                
            </div>
            
        </div>
    </div>
</div>
@endsection
