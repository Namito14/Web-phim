
<form action="{{route('locphim')}}" method="GET">
                           <style type="text/css">
                              .stylish_filter {
                                 border: 0;
                                 background: #12171b;
                                 color: #fff;
                              }
                              .btn-filter{
                                 border: 0 #b2b7bb;
                                 background: #12171b;
                                 color: #fff;
                                 padding: 9px;
                              }
                           </style>

                           <div class="col-md-2">
                              <div class="form-group">
                                 
                                 <select name="order" id="" class="form-control stylish_filter">
                                    <option value="">--Sắp xếp--</option>
                                    <option value="create_at">Ngày đăng</option>
                                    <option value="year">Năm sản xuất</option>
                                    <option value="title">Tên phim</option>
                                    <option value="topview">Lượt xem</option>
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 
                                 <select name="genre" id="" class="form-control stylish_filter">
                                    <option value="">-Thể loại-</option>
                                    @foreach($genre_home as $key => $gen_filter)
                                       <option {{ (isset($_GET['genre']) && $_GET['genre']==$gen_filter->id) ? 'selected' : ''}} value="{{$gen_filter->id}}">{{$gen_filter->title}}</option>
                                    @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-2">
                              <div class="form-group">
                                 
                                 <select name="country" id="" class="form-control stylish_filter">
                                 <option value="">-Quốc gia-</option>
                                 @foreach($country_home as $key => $count_filter)
                                    <option {{ (isset($_GET['country']) && $_GET['country']==$count_filter->id) ? 'selected' : ''}} value="{{$count_filter->id}}">{{$count_filter->title}}</option>
                                 @endforeach
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="form-group">
                                 <select name="year" class="form-control stylish_filter">
                                       <option value="" >--Năm--</option>
                                       @for ($year = 2000; $year <= 2024; $year++)
                                       <option value="{{ $year }}" {{ (isset($_GET['year']) && $_GET['year']==$year) ? 'selected' : ''}}>
                                       {{ $year }}
                                       </option>
                                       @endfor
                                 </select>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <input type="submit" value="Lọc phim" class="btn btn-sm btn-default btn-filter">
                           </div>
                              
                           
                        </form>
