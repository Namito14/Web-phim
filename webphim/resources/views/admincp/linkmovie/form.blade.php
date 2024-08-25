@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Link Movie") }}
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
                @if(isset($linkmovie))
                    <form action="{{ route('linkmovie.update', $linkmovie->id) }}" method="POST">
                        @method('PUT')
                @else 
                    <form action="{{ route('linkmovie.store') }}" method="POST">
                @endif
                        @csrf
                        <div class="mb-4">
                            <label for="title" class="block">Title:</label>
                            <input type="text" name="title" class="form-control w-full" value="{{ isset($linkmovie) ? $linkmovie->title : '' }}">
                        </div>
                        <div class="mb-4">
                            <label for="description" class="block">Description:</label>
                            <textarea style="resize: none;" id="description" name="description" class="form-control w-full">
                            {{ isset($linkmovie) ? $linkmovie->description : '' }}
                            </textarea>
                        </div>
                        <div class="mb-4">
                            <label for="active" class="block">Active:</label>
                            <select type="text" id="status" name="status" class="form-control w-full">
                                <option value="1" {{ isset($linkmovie) && $linkmovie->status == 1 ? 'selected' : '' }}>Hiển thị</option>
                                <option value="0" {{ isset($linkmovie) && $linkmovie->status == 0 ? 'selected' : '' }}>Ẩn</option>
                            </select>
                        </div>

                        
                        {{-- Button Submit --}}
                        @if(!isset($linkmovie))
                        <button type="submit" class="btn btn-primary btn-success">Thêm dữ liệu</button>
                        @else
                        <button type="submit" class="btn btn-primary btn-success">Cập nhật dữ liệu</button>
                        @endif
                    </form>
                </div>
                <table class="table" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Description</th>
                            <th scope="col">Active/Inactive</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $movielink)
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$movielink->title}}</td>
                            <td>{{$movielink->description}}</td>
                            <td>
                                @if($movielink->status)
                                    Hiển thị
                                @else
                                    Không hiển thị
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('linkmovie.destroy', $movielink->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Xóa?')" class="btn btn-danger btn-primary" type="submit">Xóa</button>
                                </form>
                                <a href="{{ route('linkmovie.edit', $movielink->id) }}" class="btn btn-warning">Sửa</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            
        </div>
    </div>
</div>
@endsection
