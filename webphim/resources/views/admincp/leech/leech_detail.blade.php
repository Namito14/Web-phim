@extends('layouts.app')

@section('content')
<div class="container">
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Leech Movie Details") }}
                </div>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">_id</th>
                                <th scope="col">name</th>
                                <th scope="col">origin_name</th>
                                <th scope="col">content</th>
                                <th scope="col">type</th>
                                <th scope="col">status</th>
                                <th scope="col">thumb_url</th>
                                <th scope="col">trailer_url</th>
                                <th scope="col">time</th>
                                <th scope="col">episode_current</th>
                                <th scope="col">episode_total</th>
                                <th scope="col">quality</th>
                                <th scope="col">lang</th>
                                <th scope="col">notify</th>
                                <th scope="col">showtimes</th>
                                <th scope="col">slug</th>
                                <th scope="col">year</th>
                                <th scope="col">view</th>
                                <th scope="col">actor</th>
                                <th scope="col">director</th>
                                <th scope="col">category</th>
                                <th scope="col">country</th>
                                <th scope="col">is_copyright</th>
                                <th scope="col">chieurap</th>
                                <th scope="col">poster_url</th>
                                <th scope="col">sub_docquyen</th>
                                <th scope="col">episodes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($resp_movie as $key => $res)
                                
                            <tr>
                                <th scope="row">{{$key}}</th>
                                <td>{{$res['_id']}}</td>
                                <td>{{$res['name']}}</td>
                                <td>{{$res['origin_name']}}</td>
                                <td>{!!$res['content']!!}</td>
                                <td>{{$res['type']}}</td>
                                <td>{{$res['status']}}</td>
                                <td><img src="{{$res['thumb_url']}}" height="80" width="80"></td>
                                <td><img src="{{$res['trailer_url']}}" height="80" width="80"></td>
                                <td>{{$res['time']}}</td>
                                <td>{{$res['episode_current']}}</td>
                                <td>{{$res['episode_total']}}</td>
                                <td>{{$res['quality']}}</td>
                                <td>{{$res['lang']}}</td>
                                <td>{{$res['notify']}}</td>
                                <td>{{$res['showtimes']}}</td>
                                <td>{{$res['slug']}}</td>
                                <td>{{$res['year']}}</td>
                                <td>{{$res['view']}}</td>
                                <td>
                                    @foreach($res['actor'] as $actor)
                                        <span class="badge badge-info">{{$actor}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($res['director'] as $director)
                                        <span class="badge badge-info">{{$director}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($res['category'] as $category)
                                        <span class="badge badge-info">{{$category['name']}}</span>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($res['country'] as $country)
                                        <span class="badge badge-info">{{$country['name']}}</span>
                                    @endforeach
                                </td>
                                
                                <td>
                                    @if($res['is_copyright'] == true) 
                                        <span class="text text-success">True</span>
                                    @else 
                                        <span class="text text-danger">False</span>
                                    @endif
                                </td>
                                <td>
                                    @if($res['chieurap'] == true) 
                                        <span class="text text-success">True</span>
                                    @else 
                                        <span class="text text-danger">False</span>
                                    @endif
                                </td>
                                <td><img src="{{$res['poster_url']}}" height="80" width="80"></td>
                                <td>
                                    @if($res['sub_docquyen'] == true) 
                                        <span class="text text-success">True</span>
                                    @else 
                                        <span class="text text-danger">False</span>
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
</div>
@endsection
