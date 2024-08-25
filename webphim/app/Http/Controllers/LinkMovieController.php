<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LinkMovie;

class LinkMovieController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $list = LinkMovie::orderBy('id', 'desc')->get();
        return view('admincp.linkmovie.form',compact('list'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:linkmovie|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên link này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên danh mục.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );

        $linkmovie = new LinkMovie();
        $linkmovie -> title = $data['title'];
        $linkmovie -> description = $data['description'];
        $linkmovie -> status = $data['status'];
        $linkmovie -> save();
        flash()->success('Thêm link phim thành công.');
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
        $linkmovie = LinkMovie::find($id);
        $list = LinkMovie::all();
        return view('admincp.linkmovie.form',compact('list', 'linkmovie'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|unique:linkmovie|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên link này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên danh mục.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );

        $linkmovie = new LinkMovie();
        $linkmovie -> title = $data['title'];
        $linkmovie -> description = $data['description'];
        $linkmovie -> status = $data['status'];
        $linkmovie -> save();
        flash()->success('Cập nhật link phim thành công.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        LinkMovie::find($id)->delete();
        flash()->info('Xóa link phim thành công.');
        return redirect()->back();
    }
}
