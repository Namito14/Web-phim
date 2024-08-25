@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Genre") }}
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
                @if(isset($genre))
                    <form action="{{ route('genre.update', $genre->id) }}" method="POST">
                        @method('PUT')
                @else 
                    <form action="{{ route('genre.store') }}" method="POST">
                @endif
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block">Title:</label>
                            <input onkeyup="ChangeToSlug()" type="text" id="slug" name="title" class="form-control w-full" value="{{ isset($genre) ? $genre->title : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="slug" class="block">Slug:</label>
                            <input type="slug" id="convert_slug" name="slug" class="form-control w-full" value="{{ isset($genre) ? $genre->slug : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block">Description:</label>
                            <textarea style="resize: none;" id="description" name="description" class="form-control w-full">
                            {{ isset($genre) ? $genre->description : '' }}
                            </textarea>
                        </div>
                        <div class="mb-4">
                            <label for="active" class="block">Active:</label>
                            <select type="text" id="status" name="status" class="form-control w-full">
                                <option value="1" {{ isset($genre) && $genre->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ isset($genre) && $genre->status == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        
                        {{-- Button Submit --}}
                        @if(!isset($genre))
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
