@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Information Website") }}
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
                @if(isset($info))
                    <form action="{{ route('info.update', $info->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @endif
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block">Title:</label>
                            <input type="text"  name="title" class="form-control w-full" value="{{ isset($info) ? $info->title : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block">Description:</label>
                            <textarea style="resize: none;" id="description" name="description" class="form-control w-full">
                            {{ isset($info) ? $info->description : '' }}
                            </textarea>
                        </div>
                        <div class="mb-4">
                            <label for="copyright" class="block">Copyright:</label>
                            <input type="text"  name="copyright" class="form-control w-full" value="{{ isset($info) ? $info->copyright : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="image" class="block">Image:</label>
                            <input type="file" name="image" class="form-control w-full">
                            
                            <img src="{{asset('uploads/logo/'.$info->logo)}}" width="150" alt="">
                            
                        </div>

                        
                        {{-- Button Submit --}}
                        
                        <button type="submit" class="btn btn-primary btn-success">Cập nhật dữ liệu</button>
                        
                    </form>
                </div>
                
            </div>
            
        </div>
    </div>
</div>
@endsection
