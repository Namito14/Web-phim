<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Episode;
use App\Models\LinkMovie;
use Carbon\Carbon;

class EpisodeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list_episode = Episode::with('movie')->orderBy('episode', 'desc')->get();
        
        return view('admincp.episode.index', compact('list_episode'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $linkmovie = LinkMovie::orderBy('id','desc')->pluck('title','id');
        $list_movie = Movie::orderBy('id', 'desc')->pluck('title','id');
        return view('admincp.episode.form', compact('list_movie','linkmovie'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
            'movie_id' => 'required|max:255',
            'link' => 'required',
            'episode' => 'required|max:255',
            'linkserver' => 'required',
        ],
        [
            'movie_id.required' => 'Bắt buộc phải chọn phim.',
            'link.required' => 'Bắt buộc phải gắn link phim.',
            'linkserver.required' => 'Bắt buộc phải gắn server phim.',
        ]
        );
        // $episode_check = Episode::where('episode',$data['episode'])->where('movie_id',$data['movie_id'])->count();  
        // if($episode_check > 0) {
        //     return redirect()->back();
        // } else {
            $ep = new Episode();
            $ep -> movie_id = $data['movie_id'];
            $ep -> linkmovie = $data['link'];
            $ep -> episode = $data['episode'];
            $ep -> server = $data['linkserver'];
            $ep -> created_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep -> updated_at = Carbon::now('Asia/Ho_Chi_Minh');
            $ep -> save();
        // }
        flash()->success('Thêm tập phim thành công.');
        return redirect()->back();
    }

    public function add_episode($id) { 
        $linkmovie = LinkMovie::orderBy('id','desc')->pluck('title','id');
        $list_server = LinkMovie::orderBy('id','desc')->get();
        $movie = Movie::find($id);
        $list_episode = Episode::with('movie')->where('movie_id',$id)->orderBy('episode', 'desc')->get();
        
        return view('admincp.episode.add_episode', compact('list_episode','movie','linkmovie','list_server'));
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
        $linkmovie = LinkMovie::orderBy('id','desc')->pluck('title','id');
        $list_movie = Movie::orderBy('id', 'desc')->pluck('title','id');
        $episode = Episode::find($id);
        return view('admincp.episode.form', compact('episode','list_movie','linkmovie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->all();
        $ep =  Episode::find($id);
        $ep -> movie_id = $data['movie_id'];
        $ep -> linkmovie = $data['link'];
        $ep -> episode = $data['episode'];
        $ep -> server = $data['linkserver'];
        $ep -> created_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep -> updated_at = Carbon::now('Asia/Ho_Chi_Minh');
        $ep -> save();
        flash()->success('Cập nhật phim thành công.');
        return redirect()->to('add-episode/'.$ep->movie_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $episode = Episode::find($id)->delete();
        flash()->info('Xóa tập phim thành công.');
        return redirect()->back();
    }

    public function select_movie() {
        $id = $_GET['id'];
        $movie = Movie::find($id);
        $output = '<option value="">---Chọn tập phim---</option>';

        for($i = 1; $i <= $movie->sotap;$i++) {
            $output .='<option value="'.$i.'">'.$i.'</option>';
        }
        echo $output;
    }
}
