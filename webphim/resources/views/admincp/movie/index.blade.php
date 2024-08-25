@extends('layouts.app')

@section('content')
<!-- <div class="modal" id="videoModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span id="video_title"></span></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p id="video_desc"></p>
                <p id="video_link"></p>
            </div>
            <div class="modal-footer">
                <button class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> -->
<div class="modal" id="videoModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title"><span id="video_title"></span></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <p id="video_desc"></p>
        <p id="video_link"></p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="container-fluid">
    <div class="py-12">
        <div class="mx-auto">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <a href="{{route('movie.create')}}" class="btn btn-primary">Add Movie</a>
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Admin Movie") }}
                </div>
                
                <table class="table table-responsive" id="tablephim">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Tập phim</th>
                            <th scope="col">Số tập</th>
                            <!-- <th scope="col">Tags</th> -->
                            <th scope="col">Time</th>
                            <th scope="col">Image</th>
                            <th scope="col">Phim Hot</th>
                            <th scope="col">Định dạng</th>
                            <!-- <th scope="col">Phụ đề</th> -->
                            <!-- <th scope="col">Description</th> -->
                            <!-- <th scope="col">Slug</th> -->
                            <!-- <th scope="col">Active</th> -->
                            <th scope="col">Category</th>
                            <th scope="col">Genre</th>
                            <th scope="col">Country</th>
                            <!-- <th scope="col">Ngày tạo</th> -->
                            <!-- <th scope="col">Ngày cập nhật</th> -->
                            <th scope="col">Năm</th>
                            <!-- <th scope="col">Seasion</th> -->
                            <th scope="col">Top Views</th>
                            <th scope="col">Manage</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($list as $key => $cate)
                        <tr>
                            <td scope="row">{{$key}}</td>
                            <td>{{$cate->title}}</td>
                            <td>
                                <a href="{{route('add-episode',[$cate->id])}}" class="btn btn-primary btn-sm">Thêm tập phim</a>

                                @foreach($cate->episode as $key => $epi)
                                <a href="" class="show_video" data-movie_video_id="{{$epi->movie_id}}" 
                                data-video_episode="{{$epi->episode}}" style="color:#fff">
                                <span class="badge badge-dark">{{$epi->episode}}</span>
                                </a>
                                @endforeach
                                
                            </td>
                            <td>{{$cate->episode_count}}/{{$cate->sotap}}</td>
                            <!-- <td>{{$cate->tags}}</td> -->
                            <td>{{$cate->time}}</td>
                            <td>
                                @php 
                                    $image_check = substr($cate->image, 0,5);
                                @endphp
                                @if($image_check == 'https')
                                    <img width="50" src="{{$cate->image}}" alt="">
                                @else
                                        <img width="50" src="{{asset('uploads/movies/'.$cate->image)}}" alt="">
                                @endif
                                
                            </td>
                            <td>
                                <!-- @if($cate->phim_hot == 0)
                                    Không
                                @else
                                    Có
                                @endif -->
                                <select name="" id="{{$cate->id}}" class="phimhot_choose">
                                @if($cate->phim_hot == 0)
                                <option value="1">Hot</option>
                                <option selected value="0">Không</option>
                                @else
                                <option selected value="1">Hot</option>
                                <option value="0">Không</option>
                                @endif
                                </select>
                            </td>
                            <td>
                                <!-- @if($cate->resolution == 0)
                                    HD
                                @elseif($cate->resolution == 1)
                                    SD
                                @elseif($cate->resolution == 2)
                                    HDCam
                                @elseif($cate->resolution == 3)
                                    Cam
                                @elseif($cate->resolution == 4)
                                    FullHD
                                @else
                                    Trailer
                                @endif -->
                                @php 
                                    $options = array('0'=>'HD', '1'=>'SD', '2'=>'HDCam','3'=>'Cam','4'=>'FullHD','5'=>'Trailer');
                                @endphp
                                
                                    <select name="" id="{{$cate->id}}" class="resolution_choose">
                                        @foreach ($options as $key => $resolution)
                                        <option value="{{$key}}" {{$cate->resolution==$key ? 'selected' : ''}}>{{$resolution}}</option>
                                        @endforeach
                                    </select>
                                
                            </td>
                            <!-- <td>
                                @if($cate->subtitle == 0)
                                    Vietsub
                                @else
                                    Thuyết minh
                                @endif
                            </td> -->
                            <!-- <td>{{$cate->description}}</td> -->
                            <!-- <td>{{$cate->slug}}</td> -->
                            <!-- <td>
                                <select name="" id="{{$cate->id}}" class="trangthai_choose">
                                @if($cate->status == 0)
                                <option value="1">Hiển thị</option>
                                <option selected value="0">Ẩn</option>
                                @else
                                <option selected value="1">Hiển thị</option>
                                <option value="0">Ẩn</option>
                                @endif
                                </select>
                            </td> -->
                                <td>
                                    <!-- {{ optional($cate->category)->title ?? 'N/A' }} -->
                                    <select id="{{$cate->id}}" name="category_id" class="form-control w-full category_choose">
                                        @foreach($category as $id => $name)
                                        <option value="{{ $id }}" {{ isset($cate) && $cate->category->id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                </td>
                                    
                                    <td>
                                    @foreach($cate->movie_genre as $gen)
                                    <span class="badge badge-dark">{{ $gen->title }}</span>
                                    @endforeach
                                    </td>
                                    
                                    <td>
                                    <!-- {{ optional($cate->country)->title ?? 'N/A' }} -->
                                    <select id="{{$cate->id}}" name="country_id" class="form-control w-full country_choose">
                                        @foreach($country as $id => $name)
                                        <option value="{{ $id }}" {{ isset($cate) && $cate->country->id == $id ? 'selected' : '' }}>
                                            {{ $name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    </td>
                                    <!-- <td>{{$cate->create_at}}</td> -->
                                    <!-- <td>{{$cate->update_at}}</td> -->
                                    <td>
                                        <form action="submit-form" method="POST">
                                        @csrf <!-- Token CSRF để bảo mật form -->
                                        <div class="form-group">
                                            <select name="year" id="{{$cate->id}}" class="form-control select-year">
                                                <option value="" disabled selected>Năm</option>
                                                @for ($year = 2000; $year <= 2024; $year++)
                                                <option value="{{ $year }}" {{ isset($cate->year) && $cate->year == $year ? 'selected' : '' }}>
                                                {{ $year }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        </form>
                                    </td>
                                    <!-- <td>
                                        <form action="submit-form" method="POST">
                                        @csrf 
                                        
                                        <div class="form-group">
                                            <select name="season" id="{{$cate->id}}" class="form-control select-season">
                                                <option value="" disabled selected>Mùa</option>
                                                @for ($season = 0; $season <= 20; $season++);
                                                <option value="{{ $season }}" {{ isset($cate->season) && $cate->season == $season ? 'selected' : '' }}>
                                                {{ $season }}
                                                </option>
                                                @endfor
                                            </select>
                                        </div>
                                        </form>
                                    </td> -->
                                    <td>
                                        <select type="text" id="{{$cate->id}}" name="topview" class="select-topview w-full">
                                            <option value="0" {{ isset($cate->topview) && $cate->topview == 0 ? 'selected' : '' }}>Ngày</option>
                                            <option value="1" {{ isset($cate->topview) && $cate->topview == 1 ? 'selected' : '' }}>Tuần</option>
                                            <option value="2" {{ isset($cate->topview) && $cate->topview == 2 ? 'selected' : '' }}>Tháng</option>
                                        </select>
                                    </td>
                                    <td>
                                        <form action="{{ route('movie.destroy', $cate->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button onclick="return confirm('Xóa?')" class="btn btn-danger btn-primary" type="submit">Xóa</button>
                                        </form>
                                        <a href="{{ route('movie.edit', $cate->id) }}" class="btn btn-warning">Sửa</a>
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
