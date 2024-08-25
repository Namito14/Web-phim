<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Genre;

class GenreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Genre::all();
        return view('admincp.genre.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincp.genre.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:genres|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên thể loại này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên thể loại.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        $genre = new Genre();
        $genre -> title = $data['title'];
        $genre -> slug = $data['slug'];
        $genre -> description = $data['description'];
        $genre -> status = $data['status'];
        $genre -> save();
        flash()->success('Thêm thể loại thành công.');
        return redirect()->back();
        
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
        $genre = Genre::find($id);
        $list = Genre::all();
        return view('admincp.genre.form',compact('list', 'genre'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:genres|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên thể loại này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên thể loại.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        $genre = Genre::find($id);
        $genre -> title = $data['title'];
        $genre -> slug = $data['slug'];
        $genre -> description = $data['description'];
        $genre -> status = $data['status'];
        $genre -> save();
        flash()->success('Cập nhật thể loại thành công.');
        return redirect()->route('genre.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Genre::find($id)->delete();
        flash()->info('Xóa thể loại thành công.');
        return redirect()->back();
    }
}
