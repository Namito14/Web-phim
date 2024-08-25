<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Country;
use App\Models\Genre;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;

class LeechMovieController extends Controller
{
    public function leech_movie() {
        $resp =  Http::withOptions(['verify' => false])
        ->get('https://ophim1.com/danh-sach/phim-moi-cap-nhat?page=1')->json();
        return view('admincp/leech/index',compact('resp'));   
    }

    public function leech_episode($slug) {
        $resp =  Http::withOptions(['verify' => false])
        ->get('https://ophim1.com/phim/'.$slug)->json();
        return view('admincp/leech/leech_episode',compact('resp'));
    }

    public function leech_detail($slug) {
        $resp =  Http::withOptions(['verify' => false])
        ->get('https://ophim1.com/phim/'.$slug)->json(); 
        $resp_movie[] = $resp['movie'];
        return view('admincp/leech/leech_detail',compact('resp_movie'));
    }

    public function leech_episode_store(Request $request, $slug) {
        $movie = Movie::where('slug',$slug)->first();
        $resp =  Http::withOptions(['verify' => false])->get('https://ophim1.com/phim/'.$slug)->json();
        foreach($resp['episodes'] as $key => $res) {
            foreach($res['server_data'] as $key_data => $res_data) {
                $ep = new Episode();
                $ep -> movie_id = $movie->id;
                $ep -> linkmovie = '<p><iframe allowfullscreen frameborder="0" height="360" scrolling="0" src="'.$res_data['link_embed'].'" width="100%"></iframe></p>';
                $ep -> episode = $res_data['name'];
                if($key_data == 0) {
                    $linkmovie = LinkMovie::orderBy('id','desc')->first();
                    $ep -> server = $linkmovie->id;
                } else {
                    $linkmovie = LinkMovie::orderBy('id','asc')->first();
                    $ep -> server = $linkmovie->id;
                }
                $ep -> created_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep -> updated_at = Carbon::now('Asia/Ho_Chi_Minh');
                $ep -> save();
            } 
            
        }
        return redirect()->back();
    }

    public function leech_store(Request $request, $slug) {
        $resp =  Http::withOptions(['verify' => false])
        ->get('https://ophim1.com/phim/'.$slug)->json(); 
        $resp_movie[] = $resp['movie'];
        $movie = new Movie();
        foreach($resp_movie as $key => $res) {
        $movie -> title = $res['name'];
        $movie -> sotap = $res['episode_total'];
        $movie -> trailer = $res['trailer_url'];
        // $movie -> tags = $res['tags'];
        $movie -> time = $res['time'];
        $movie -> resolution = 1;
        $movie -> subtitle = 0;
        $movie -> name_eng = $res['origin_name'];
        $movie -> phim_hot = 1;
        $movie -> slug = $res['slug'];
        $movie -> description = $res['content'];
        $movie -> status = 1;

        $category = Category::orderBy('id','desc')->first();
        $movie -> category_id = $category->id;

        $genre = Genre::orderBy('id','desc')->first();
        $movie -> genre_id = $genre->id;

        $country = Country::orderBy('id','desc')->first();
        $movie -> country_id = $country->id;
        
        $movie -> count_view = $res['view'];

        $movie -> image = $res['thumb_url'];

        $movie -> create_at = Carbon::now('Asia/Ho_Chi_Minh');
        $movie -> update_at = Carbon::now('Asia/Ho_Chi_Minh');

        $movie -> save();

        $movie->movie_genre()->attach($genre);
        
        }
        return redirect()->back();
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
