@extends('layout')
@section('content')

<div class="row container" id="wrapper">
            <div class="halim-panel-filter">
               <div class="panel-heading">
                  <div class="row">
                     <div class="col-xs-6">
                        <div class="yoast_breadcrumb hidden-xs"><h4><span><a href="{{route('homepage')}}">Phim</a> / <span class="breadcrumb_last" aria-current="page">Đăng ký</span></span></h4></div>
                     </div>
                  </div>
               </div>
               <div id="ajax-filter" class="panel-collapse collapse" aria-expanded="true" role="menu">
                  <div class="ajax"></div>
               </div>
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
            <main id="main-contents" class="col-xs-12 col-sm-12 col-md-8">
               <form method="POST" action="{{route('register-publisher')}}">
                  @csrf
                  <div class="form-group">
                     <label for="exampleInputEmail1">Tài khoản</label>
                     <input type="text" name="username" class="form-control" placeholder="Enter user name">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Số điện thoại</label>
                     <input type="number" name="phone" class="form-control" placeholder="Enter your phone number">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputEmail1">Email address</label>
                     <input type="email" name="email" class="form-control" aria-describedby="emailHelp" placeholder="Enter email">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Mật khẩu</label>
                     <input type="password" name="password" class="form-control" placeholder="Password">
                  </div>
                  <div class="form-group">
                     <label for="exampleInputPassword1">Xác nhận mật khẩu</label>
                     <input type="password" name="password_confirmation" class="form-control" placeholder="Password">
                  </div>
                  <button type="submit" class="btn btn-primary">Đăng ký</button>
               </form>
            </main>
            <!-- Sidebar -->
            @include('pages.include.sidebar')
         </div>

@endsection