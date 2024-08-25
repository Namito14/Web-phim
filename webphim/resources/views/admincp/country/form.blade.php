@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin country movie") }}
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
                @if(isset($country))
                    <form action="{{ route('country.update', $country->id) }}" method="POST">
                        @method('PUT')
                @else 
                    <form action="{{ route('country.store') }}" method="POST">
                @endif
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block">Title:</label>
                            <input onkeyup="ChangeToSlug()" type="text" id="slug" name="title" class="form-control w-full" value="{{ isset($country) ? $country->title : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="slug" class="block">Slug:</label>
                            <input type="slug" id="convert_slug" name="slug" class="form-control w-full" value="{{ isset($country) ? $country->slug : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block">Description:</label>
                            <textarea style="resize: none;" id="description" name="description" class="form-control w-full">
                            {{ isset($country) ? $country->description : '' }}
                            </textarea>
                        </div>
                        <div class="mb-4">
                            <label for="active" class="block">Active:</label>
                            <select type="text" id="status" name="status" class="form-control w-full">
                                <option value="1" {{ isset($country) && $country->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ isset($country) && $country->status == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        
                        {{-- Button Submit --}}
                        @if(!isset($country))
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
