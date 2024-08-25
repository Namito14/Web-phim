<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Post;
use App\Http\Requests\PostRequest;
use Illuminate\Database\Eloquent\Model;
class categoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Category::orderBy('position', 'asc')->get();
        return view('admincp.category.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincp.category.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // $data = $request->all();

        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên danh mục này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên danh mục.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );

        $category = new Category();
        $category -> title = $data['title'];
        $category -> slug = $data['slug'];
        $category -> description = $data['description'];
        $category -> status = $data['status'];
        $category -> save();
        flash()->success('Thêm danh mục thành công.');
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
        $category = Category::find($id);
        $list = Category::orderBy('position', 'asc')->get();
        return view('admincp.category.form',compact('list', 'category'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|unique:categories|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên danh mục này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên danh mục.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        $data = $request->all();
        $category = Category::find($id);
        $category -> title = $data['title'];
        $category -> slug = $data['slug'];
        $category -> description = $data['description'];
        $category -> status = $data['status'];
        $category -> save();
        flash()->info('Cập nhật danh mục thành công.');
        return redirect()->route('category.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Category::find($id)->delete();
        flash()->info('Xóa danh mục thành công.');
        return redirect()->back();
    }

    public function resorting(Request $request) {
        $data = $request->all();

        foreach($data['array_id'] as $key => $value) {
            $category = Category::find($value);
            $category -> position = $key;
            $category->save();
        }
    }
}
