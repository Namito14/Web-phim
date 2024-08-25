@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Leech Movie") }}
                </div>
                
                <table class="table table-responsive" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Origin Name</th>
                            <th scope="col">Image</th>
                            <th scope="col">Image Poster</th>
                            <th scope="col">Slug</th>
                            <th scope="col">_Id</th>
                            <th scope="col">Year</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resp['items'] as $key => $res)
                            
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$res['name']}}</td>
                            <td>{{$res['origin_name']}}</td>
                            <td><img src="{{$resp['pathImage'].$res['thumb_url']}}" height="80" width="80"></td>
                            <td><img src="{{$resp['pathImage'].$res['poster_url']}}" height="80" width="80"></td>
                            <td>{{$res['slug']}}</td>
                            <td>{{$res['_id']}}</td>
                            <td>{{$res['year']}}</td>
                            <td>
                                <a href="{{route('leech-detail',$res['slug'])}}" class="btn btn-primary btn-sm">Details Phim</a>
                                <a href="{{route('leech-episode',$res['slug'])}}" class="btn btn-danger btn-sm">Tập Phim</a>
                                @php
                                    $movie = \App\Models\Movie::where('slug',$res['slug'])->first();
                                @endphp
                                @if(!$movie)
                                <form action="{{route('leech-store',$res['slug'])}}" method="post">
                                @csrf
                                    <input type="submit" class="btn btn-success btn-sm" value="Add Movie">
                                </form>
                                @else
                                    <form action="{{ route('movie.destroy', $movie->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Bạn có chắc chắn muốn xóa?')" class="btn btn-danger btn-primary btn-sm" type="submit">Delete Phim</button>
                                </form>
                                @endif
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
