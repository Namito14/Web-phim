@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Episode") }}
                </div>

                <div class="p-6 text-gray-900 dark:text-gray-100">
                @if(isset($episode))
                    <form action="{{ route('episode.update', $episode->id) }}" method="POST" enctype="multipart/form-data">
                        @method('PUT')
                @else 
                    <form action="{{ route('episode.store') }}" method="POST" enctype="multipart/form-data"> 
                @endif
                        @csrf
                        
                        <div class="mb-4">
                            <div class="mb-4">
                                <label for="movie_title" class="block">Phim:</label>
                                <input type="text"  name="movie_title" class="form-control w-full" readonly value="{{ isset($movie) ? $movie->title : '' }}">
                                <input type="hidden" name="movie_id" value="{{ isset($movie) ? $movie->id : '' }}">
                            </div>
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
                            <select name="episode" class="form-control">
                            @for ($i = 1; $i <= $movie->sotap; $i++)
                                <option value="{{ $i }} {{ $i == $movie->sotap ? '' : '' }}" >{{ $i }}</option>
                            @endfor
                            </select>
                        </div>
                        @endif

                        <div class="mb-4">
                            <label for="linkserver" class="block">Link Server:</label>
                            <select name="linkserver" class="form-control w-full">
                                @foreach($linkmovie as $id => $name)
                                    <option value="{{ $id }}">
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
                <!-- Liệt kê tập phim -->
                <table class="table table-responsive" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Episode</th>
                            <th scope="col">Link</th>
                            <th scope="col">Server</th>
                            <!-- <th scope="col">Status</th> -->
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list_episode as $key => $episode)
                            
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$episode->movie->title}}</td>
                            <td><img width="60%" src="{{asset('uploads/movies/'.$episode->movie->image)}}" alt=""></td>
                            <td>{{$episode->episode}}</td>
                            <td style="width: 20%;">{{$episode->linkmovie}}</td>
                            <td style="width: 20%;">
                                @foreach($list_server as $key => $server_link)
                                    @if($episode->server == $server_link->id)
                                        {{$server_link->title}}
                                    @endif
                                @endforeach
                            </td>
                            <!-- <td>
                                @if($episode->status)
                                    Hiển thị
                                @else
                                    Không hiển thị
                                @endif
                            </td> -->
                            <td>
                                <form action="{{ route('episode.destroy', $episode->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Xóa?')" class="btn btn-danger btn-primary" type="submit">Xóa</button>
                                </form>
                                <a href="{{ route('episode.edit', $episode->id) }}" class="btn btn-warning">Sửa</a>
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
