@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Episode") }}
                </div>
                
                <table class="table table-responsive" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Image</th>
                            <th scope="col">Episode</th>
                            <th scope="col">Link</th>
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
