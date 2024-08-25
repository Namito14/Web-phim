<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;

class InfoController extends Controller
{
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
        $info = Info::find(1);
        return view('admincp.info.form',compact('info'));
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
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required|max:255',
            'copyright' => 'required|max:255',
            'image' => 'image|mimes:jpg,bmp,png,jpeg,gif,svg|max:2048|dimensions:min_width=100,min_height=100,max_width=2000,max_height=2000',
        ],
        [
            'title.required' => 'Bắt buộc phải điền tên danh mục.',
            'copyright.required' => 'Bắt buộc phải điền Copyright.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        
        $info = Info::find($id);
        $info -> title = $data['title'];
        $info -> copyright = $data['copyright'];
        $info -> description = $data['description'];
        // Thêm hình ảnh
        $get_image = $request->file('image');

        if($get_image) {
            $get_name_image = $get_image->getClientOriginalName();
            $name_image = current(explode('.',$get_name_image));
            $new_image = $name_image.rand(0,9999).'.'.$get_image->getClientOriginalExtension();
            $get_image->move('uploads/logo/',$new_image);
            $info -> logo = $new_image;
        }
        $info -> save();
        flash()->info('Cập nhật thông tin web thành công.');
        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
