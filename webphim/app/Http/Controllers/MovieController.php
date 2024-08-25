<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Movie_Genre;
use App\Models\Category;
use App\Models\Genre;
use App\Models\Country;
use App\Models\Episode;
use App\Models\Info;

use Carbon\Carbon;
use Storage;
use File;
class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Movie::with('category','movie_genre','country','genre')->withCount('episode')->orderBy('id', 'desc')->get();
        $category = Category::pluck('title','id');
        $country = Country::pluck('title','id');
        $path = public_path()."/json_file/";

        if(!is_dir($path)) {
            mkdir($path, 0777, true);
        }
        File::put($path.'movie.json', json_encode($list));

        return view('admincp.movie.index',compact('list','category','country'));
    }

    public function category_choose(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> category_id = $data['category_id'];
        $movie->save();
    }

    public function country_choose(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> country_id = $data['country_id'];
        $movie->save();
    }

    public function trangthai_choose(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> status = $data['trangthai_val'];
        $movie->save();
    }

    public function phimhot_choose(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> phim_hot = $data['phimhot_val'];
        $movie->save();
    }

    public function resolution_choose(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $movie -> resolution = $data['resolution_val'];
        $movie->save();
    }


    public function update_year(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->year = $data['year'];
        $movie->save();
    }

    public function update_season(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->season = $data['season'];
        $movie->save();
    }

    public function update_topview(Request $request)
    {
        $data = $request->all();
        $movie = Movie::find($data['id_phim']);
        $movie->topview = $data['topview'];
        $movie->save();
    }

    public function filter_topview(Request $request) {
        $data = $request->all();
        $movie = Movie::where('topview',$data['value'])->orderBy('update_at','desc')->take(10)->get();
        $output = '';
        foreach($movie as $key => $mov) {
            if($mov->resolution==0){
                $text = 'HD';
            } elseif ($mov->resolution==1) {
                $text = 'SD';
            } elseif ($mov->resolution==2) {
                $text = 'HDCam';
            }
            else{
                $text = 'Cam';
            }

            $output .= '
            <div class="item post-37176">
            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                <div class="item-link">
                    <img src="'.url('uploads/movies/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                    <span class="is_trailer">'.$text.'</span>
                </div>
                <p class="title">'.$mov->title.'</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            <div class="viewsCount" style="color: #9d9d9d;">'.$mov->year.'</div>
            <div style="float: left;">
                <ul class="list-inline rating" title="Average Rating">';
                                    for($count=1; $count<=5; $count++) {
                                       $output .='<li title="star_rating" 
                                       style="font-size:15px; color:#ffcc00; padding: 0; ">&#9733;
                                       </li>';
                                    }
                                       
                                      
                                    $output .='</ul>
            </div>
            </div>';
        }
        echo $output;
    }

    public function filter_default(Request $request) {
        
        $data = $request->all();
        $movie = Movie::where('topview',0)->orderBy('update_at','desc')->take(10)->get();
        $output = '';
        foreach($movie as $key => $mov) {
            if($mov->resolution==0){
                $text = 'HD';
            } elseif ($mov->resolution==1) {
                $text = 'SD';
            } elseif ($mov->resolution==2) {
                $text = 'HDCam';
            } elseif ($mov->resolution==3) {
                $text = 'Cam';
            } elseif ($mov->resolution==4) {
                $text = 'FullHD';
            }
            else{
                $text = 'Trailer';
            }

            $output .= '
            <div class="item post-37176">
            <a href="'.url('phim/'.$mov->slug).'" title="'.$mov->title.'">
                <div class="item-link">
                    <img src="'.url('uploads/movies/'.$mov->image).'" class="lazy post-thumb" alt="'.$mov->title.'" title="'.$mov->title.'" />
                    <span class="is_trailer">'.$text.'</span>
                </div>
                <p class="title">'.$mov->title.'</p>
            </a>
            <div class="viewsCount" style="color: #9d9d9d;">3.2K lượt xem</div>
            <div class="viewsCount" style="color: #9d9d9d;">'.$mov->year.'</div>
            <div style="float: left;">
                <ul class="list-inline rating" title="Average Rating">';
                                    for($count=1; $count<=5; $count++) {
                                       $output .='<li title="star_rating" 
                                       style="font-size:15px; color:#ffcc00; padding: 0; ">&#9733;
                                       </li>';
                                    }
                                       
                                      
                                    $output .='</ul>
            </div>
            </div>';
        }
        echo $output;
    }

    public function watch_video(Request $request) {
        $data = $request->all();
        $movie = Movie::find($data['movie_id']);
        $video = Episode::where('movie_id', $data['movie_id'])->where('episode',$data['episode_id'])->first();
        $output['video_title'] = $movie->title.'- tập '.$video->episode;
        $output['video_desc'] = $movie->description;
        $output['video_link'] = $video->linkmovie;

        echo json_encode($output);

    }

    

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $list_genre = Genre::all();
        $country = Country::pluck('title','id');
        return view('admincp.movie.form',compact('genre', 'country', 'category','list_genre'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:movies|max:255',
            'sotap' => 'required',
            'trailer' => '',
            'time' => 'required',
            'resolution' => 'required',
            'subtitle' => 'required',
            'name_eng' => 'required',
            'phim_hot' => 'required',
            'slug' => 'required',
            'status' => 'required',
            'category_id' => 'required',
            'country_id' => 'required',
            'image' => 'required|image|mimes:jpg,bmp,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
            'description' => 'required',
            'genre' => 'required',
        ],
        [
            'title.unique' => 'Tên thể loại này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên phim.',
            'sotap.required' => 'Bắt buộc phải điền tên số tập.',
            'image.required' => 'Bắt buộc phải có hình ảnh.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        $movie = new Movie();
        $movie -> title = $data['title'];
        $movie -> sotap = $data['sotap'];
        $movie -> trailer = $data['trailer'];
        // $movie -> tags = $data['tags'];
        $movie -> time = $data['time'];
        $movie -> resolution = $data['resolution'];
        $movie -> subtitle = $data['subtitle'];
        $movie -> name_eng = $data['name_eng'];
        $movie -> phim_hot = $data['phim_hot'];
        $movie -> slug = $data['slug'];
        $movie -> description = $data['description'];
        $movie -> status = $data['status'];
        $movie -> category_id = $data['category_id'];
        $movie -> country_id = $data['country_id'];
        
        $movie -> count_view = rand(100,99999);

        $movie -> create_at = Carbon::now('Asia/Ho_Chi_Minh');
        $movie -> update_at = Carbon::now('Asia/Ho_Chi_Minh');

        foreach($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }

        // Thêm hình ảnh
        $get_image = $request->file('image');

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/movies/',$new_image);
            $movie -> image = $new_image;
        }
        $movie -> save();

        // Thêm nhiều thể loại cho phim
        $movie->movie_genre()->attach($data['genre']);

        flash()->success('Thêm phim thành công.');
        return redirect()->route('movie.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::pluck('title','id');
        $genre = Genre::pluck('title','id');
        $country = Country::pluck('title','id');
        $list_genre = Genre::all();
        $movie = Movie::find($id);
        $movie_genre = $movie->movie_genre;
        return view('admincp.movie.form',compact('genre', 'country', 'category','movie','list_genre','movie_genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        
        $movie = Movie::find($id);
        $movie -> title = $data['title'];
        $movie -> sotap = $data['sotap'];
        $movie -> trailer = $data['trailer'];
        // $movie -> tags = $data['tags'];
        $movie -> time = $data['time'];
        $movie -> resolution = $data['resolution'];
        $movie -> subtitle = $data['subtitle'];
        $movie -> name_eng = $data['name_eng'];
        $movie -> phim_hot = $data['phim_hot'];
        $movie -> slug = $data['slug'];
        $movie -> description = $data['description'];
        $movie -> status = $data['status'];
        $movie -> category_id = $data['category_id'];
        $movie -> country_id = $data['country_id'];
        // $movie -> count_view = rand(100,99999);

        $movie -> update_at = Carbon::now('Asia/Ho_Chi_Minh');

        // Thêm hình ảnh
        $get_image = $request->file('image');

        if($get_image) {
            if(file_exists('uploads/movies/'.$movie->image)) {
                unlink('uploads/movies/'.$movie->image);
            } else {
                $get_name_image = $get_image->getClientOriginalName();
                $name_image = current(explode('.',$get_name_image));
                $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
                $get_image->move('uploads/movies/',$new_image);
                $movie->image = $new_image;
            }
            
        }

        foreach($data['genre'] as $key => $gen) {
            $movie->genre_id = $gen[0];
        }
        $movie -> save();

        $movie->movie_genre()->sync($data['genre']);

        flash()->success('Cập nhật phim thành công.');
        return redirect()->route('movie.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $movie = Movie::find($id);
        // xóa ảnh
        if(file_exists('uploads/movies/'.$movie->image)) {
            unlink('uploads/movies/'.$movie->image);
        }
        // Xóa thể loại
        
        Movie_Genre::whereIn('movie_id',[$movie->id])->delete();

        // Xóa tập phim
        Episode::whereIn('movie_id',[$movie->id])->delete();

        $movie -> delete();

        flash()->info('Xóa phim thành công.');
        return redirect()->back();
    }
}
