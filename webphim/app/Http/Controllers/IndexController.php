<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\Movie_Genre;
use App\Models\Rating;
use App\Models\LinkMovie;
use App\Models\Info;
use App\Models\Publisher;
use App\Models\Favorite;
use Session;
use DB;

class IndexController extends Controller
{
    public function home() {
        $info = Info::find(1);
        
        $meta_title = $info->title;
        $meta_description = $info->description;
        $meta_image = '';
        
        $phimhot = Movie::withCount('episode')->where('phim_hot',1)->where('status',1)->orderBy('update_at','desc')->get();
        
        $category_home = Category::with(  ['movie'=>function($q){$q->withCount('episode')->where('status',1);}  ])->orderBy('id','DESC')->where('status',1)->get();
        return view('pages.home',compact('category_home','phimhot','meta_title','meta_description','meta_image'));
    }

    public function dang_nhap() {
        $info = Info::find(1);
        
        $meta_title = "Đăng nhập vào website";
        $meta_description = "Đăng nhập vào website";
        $meta_image = '';
        
        $category_home = Category::with(  ['movie'=>function($q){$q->withCount('episode')->where('status',1);}  ])->orderBy('id','DESC')->where('status',1)->get();
        return view('pages.users.dangnhap',compact('category_home','meta_title','meta_description','meta_image'));
    }

    public function dang_ki() {
        $info = Info::find(1);
        
        $meta_title = "Đăng ký thành viên";
        $meta_description = "Đăng ký thành viên";
        $meta_image = '';
        
        $category_home = Category::with(  ['movie'=>function($q){$q->withCount('episode')->where('status',1);}  ])->orderBy('id','DESC')->where('status',1)->get();
        return view('pages.users.dangki',compact('category_home','meta_title','meta_description','meta_image'));
    }


    public function register_publisher(Request $request) {
        $data = $request->validate([
            'username' => 'required|unique:publishers|max:100',
            'phone' => 'required|max:50',
            'email' => 'required|unique:publishers|max:100',
            'password' => 'required|required_with:password_confirmation|same:password|max:150',
            'password_confirmation' => 'required|same:password',
        ],
        [
            'username.unique' => 'Tên tài khoản này đã tồn tại.',
            'username.required' => 'Bắt buộc phải điền tên danh mục.',
            'phone.required' => 'Bắt buộc phải điền số điện thoại.',
            'email.required' => 'Bắt buộc phải điền email.',
            'email.unique' => 'Email đã tồn tại.',
            'password.required' => 'Bắt buộc phải nhập mật khẩu.',
            'password_confirmation.required' => 'Bắt buộc phải nhập mật khẩu.',
        ]
        );

        $publisher = new Publisher();
        $publisher -> username = $data['username'];
        $publisher -> phone = $data['phone'];
        $publisher -> email = $data['email'];
        $publisher -> password = md5($data['password']);
        $publisher -> save();
        flash()->success('Đăng ký thành công.');
        return redirect()->back();
    }

    public function login_publisher(Request $request) {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ],
        [
            'username.required' => 'Bắt buộc phải điền tên danh mục.',
            'password.required' => 'Bắt buộc phải nhập mật khẩu.',
        ]
        );

        $publisher = Publisher::where('username', $data['username'])->where('password', md5($data['password']))->first();
        if($publisher) {
            Session::put('login_publisher', true);
            Session::put('publisher_id', $publisher->id);
            Session::put('username', $publisher->username);
            Session::put('email_publisher', $publisher->email);
            flash()->success('Đăng nhập thành công.');
            return redirect()->to('/');
        } else {
            flash()->error('Sai mật khẩu hoặc tài khoản không tồn tại.');
            return redirect()->back();
        }
    }

    public function dang_xuat() {
        Session::forget('login_publisher');
        Session::forget('publisher_id');
        Session::forget('username');
        Session::forget('email_publisher');
        flash()->success('Đăng xuất thành công.');
        return redirect()->back();
    }

    public function favorite() {
        $info = Info::find(1);
        
        $meta_title = "Phim yêu thích";
        $meta_description = "Phim yêu thích";
        $meta_image = '';

        $favorites = Favorite::with('publisher')->where('publisher_id',Session::get('publisher_id'))->orderBy('date_updated','desc')->get();

        return view('pages.users.favorite',compact('meta_title','meta_description','meta_image','favorites'));
    }

    public function themyeuthich(Request $request) {
        $data = $request->all();

        $favo_check = Favorite::where('title',$data['title'])->where('publisher_id',$data['publisher_id'])->first();
        if($favo_check) {
            echo 'Fail';
        } else {
            $favo = new Favorite();
            $favo -> title = $data['title'];
            $favo -> image = $data['image'];
            $favo -> slug = $data['slug'];
            $favo -> status  = 0;
            $favo -> publisher_id = $data['publisher_id'];
            $favo -> save();
            flash()->success('Đăng ký thành công.');
            return redirect()->back();
            echo 'Done';
        }
        
    }

    public function timkiem() {
        if(isset($_GET['search'])) {
            $search = $_GET['search'];

            $meta_title = "Tìm kiếm phim";
            $meta_description = "Tìm kiếm phim";

            $movie = Movie::withCount('episode')->where('title','LIKE','%'.$search.'%')->orderBy('update_at','desc')->paginate(40);

            return view('pages.search',compact('search','movie','meta_title','meta_description'));
        } else {
            return redirect()->to('/');
        }
    }

    public function locphim() {
        // Get parameters from URL
        $order = $_GET['order'];
        $genre_get = $_GET['genre'];
        $country_get = $_GET['country'];
        $year_get = $_GET['year'];
    
        // Check if all parameters are empty, if so, redirect back
        if($order == '' && $genre_get == '' && $country_get == '' && $year_get == '') {
            return redirect()->back();
        } else {
            $meta_title = "Lọc theo phim";
            $meta_description = "Lọc theo phim";
            $meta_image = "";
    
            // Get movie IDs for the specified genre
            $many_genre = [];
            if ($genre_get) {
                $movie_genre = Movie_Genre::where('genre_id', $genre_get)->get();
                foreach ($movie_genre as $movi) {
                    $many_genre[] = $movi->movie_id;
                }
            }
    
            // Fetch movies with conditions
            $movie_array = Movie::withCount('episode'); // Lấy ra phim và đếm số tập
            
            if ($country_get) { // Có lọc quốc gia
                $movie_array = $movie_array->where('country_id', $country_get);  
            } 
            
            if ($year_get) {
                $movie_array = $movie_array->where('year', $year_get);
            } 
            
            if ($order) {
                $movie_array = $movie_array->orderBy($order, 'desc');
            }
    
            if ($genre_get && !empty($many_genre)) {
                $movie_array = $movie_array->whereIn('id', $many_genre);
            }
    
            $movie_array = $movie_array->with('movie_genre');
    
            // Paginate results
            $movie = $movie_array->paginate(40);
    
            // Return view with movies and meta data
            return view('pages.locphim', compact('movie', 'meta_title', 'meta_description', 'meta_image'));
        }
    }
    
    public function category($slug) {

        $cate_slug = Category::where('slug',$slug)->first();

        $meta_title = $cate_slug->title;
        $meta_description = $cate_slug->description;

        $movie = Movie::withCount('episode')->where('category_id',$cate_slug->id)->orderBy('update_at','desc')->paginate(40);

        return view('pages.category',compact('cate_slug','movie','meta_title','meta_description'));
    }

    public function year($year) {

        $meta_title = 'Năm phim : '.$year;
        $meta_description = 'Tìm phim năm :'.$year;

        $year = $year;

        $movie = Movie::withCount('episode')->where('year',$year)->orderBy('update_at','desc')->paginate(40);

        return view('pages.year',compact('year','movie','meta_title','meta_description'));
    }
    public function genre($slug) {

        $genre_slug = Genre::where('slug',$slug)->first();

        $meta_title = $genre_slug->title;
        $meta_description = $genre_slug->description;

        // Nhiều thể loại
        $movie_genre = Movie_Genre::where('genre_id',$genre_slug->id)->get();
        $many_genre = [];
        foreach ($movie_genre as $key => $movi) {
            $many_genre[] = $movi->movie_id;
        }

        $movie = Movie::withCount('episode')->whereIn('id',$many_genre)->orderBy('update_at','desc')->paginate(40);

        return view('pages.genre',compact('genre_slug','movie','meta_title','meta_description'));
    }
    public function country($slug) {

        $country_slug = Country::where('slug',$slug)->first();

        $meta_title = $country_slug->title;
        $meta_description = $country_slug->description;

        $movie = Movie::withCount('episode')->where('country_id',$country_slug->id)->orderBy('update_at','desc')->paginate(40);

        return view('pages.country',compact('country_slug','movie','meta_title','meta_description'));
    }
    public function movie($slug) {

        $movie = Movie::with('category','genre','country','movie_genre')->where('slug',$slug)->where('status',1)->first();

        $meta_title = $movie->title;
        $meta_description = $movie->description;

        $episode_tapdau = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','asc')->take(1)->first();

        $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))
        ->whereNotIn('slug',[$slug])->get();

        // Lấy 3 tập gần nhất
        $episode = Episode::with('movie')->where('movie_id',$movie->id)->orderBy('episode','desc')->take(3)->get();
        // Lấy tổng tập phim đã thêm
        $episode_current_list = Episode::with('movie')->where('movie_id',$movie->id)->get();
        $episode_current_list_count = $episode_current_list->count();

        // rating movie
        $rating = Rating::where('movie_id',$movie->id)->avg('rating');
        $rating = round($rating);

        $count_total = Rating::where('movie_id',$movie->id)->count();

        // increase movie view
        $count_views = $movie->conut_view;
        $count_views + 1;
        $movie->count_view = $count_views;
        $movie->save();

        

        return view('pages.movie',compact('movie','related','episode','episode_tapdau','episode_current_list_count','rating','count_total'
        ,'meta_title','meta_description'));
    }

    public function add_rating(Request $request) {
        $data = $request->all();
        $ip_address = $request->ip();

        $rating_count = Rating::where('movie_id',$data['movie_id'])->where('ip_address',$ip_address)->count();
        if($rating_count>0) {
            echo 'exist';
        } else {
            $rating = new Rating();
            $rating->movie_id = $data['movie_id'];
            $rating->rating = $data['index'];
            $rating->ip_address = $ip_address;
            $rating->save();
            echo 'Done';
        }
    }
    
    public function watch($slug,$tap,$server_active) {

        $movie = Movie::with('category','genre','country','movie_genre','episode')->where('slug',$slug)->where('status',1)->first();

        $meta_title = $movie->title;
        $meta_description = $movie->description;

        $related = Movie::with('category','genre','country')->where('category_id',$movie->category->id)->orderBy(DB::raw('RAND()'))
        ->whereNotIn('slug',[$slug])->get();

        if(isset($tap)) {
            $tapphim = $tap;
            $tapphim = substr($tapphim,4,2);
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        } else {
            $tapphim = 1;
            $episode = Episode::where('movie_id',$movie->id)->where('episode',$tapphim)->first();
        }

        $server = LinkMovie::orderBy('id','desc')->get();

        $episode_movie = Episode::where('movie_id',$movie->id)->get()->unique('server');
        $episode_list = Episode::where('movie_id',$movie->id)->orderBy('episode','asc')->get();
 
        return view('pages.watch',compact('movie','episode','tapphim','related','meta_title','meta_description','server','episode_movie','episode_list','server_active'));
    }
    public function episode() {
        return view('pages.episode');
    }

}
