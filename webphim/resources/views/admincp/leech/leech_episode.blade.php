@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Leech Movie") }}
                </div>
                
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Slug</th>
                            <th scope="col">Episode Total</th>
                            <th scope="col">Episode Current</th>
                            <th scope="col">Link Embed</th>
                            <th scope="col">Link M3U8</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($resp['episodes'] as $key => $res)
                            
                        <tr>
                            <th scope="row">{{$key}}</th>
                            <td>{{$resp['movie']['name']}}</td>
                            <td>{{$resp['movie']['slug']}}</td>
                            <td>{{$resp['movie']['episode_total']}}</td>

                            <td>
                                {{$res['server_name']}}
                            </td>
                            
                            <td>
                                @foreach($res['server_data'] as $key => $server_1)
                                <ul>
                                    <li>{{$server_1['name']}}</li>
                                    <input type="text" class="form-control" value="{{$server_1['link_embed']}}">
                                </ul>
                                @endforeach
                            </td>

                            <td>
                                @foreach($res['server_data'] as $key => $server_2)
                                <ul>
                                    <li>{{$server_2['name']}}</li>
                                    <input type="text" class="form-control" value="{{$server_2['link_m3u8']}}">
                                </ul>
                                @endforeach
                            </td>

                            <td>
                                    <form action="{{ route('leech-episode-store', [$resp['movie']['slug']]) }}" method="POST">
                                        @csrf
                                        <input type="submit" value="Thêm tập phim" class="btn btn-success btn-sm">
                                    </form>

                                <!-- <form action="" method="POST">
                                    @csrf
                                    <input type="submit" value="Xóa tập phim" class="btn btn-danger btn-sm">
                                </form> -->
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
