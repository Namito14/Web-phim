<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $list = Country::all();
        return view('admincp.country.index',compact('list'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admincp.country.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        // $data = $request->all();
        $data = $request->validate([
            'title' => 'required|unique:countries|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên quốc gia này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên quốc gia.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        $country = new Country();
        $country -> title = $data['title'];
        $country -> slug = $data['slug'];
        $country -> description = $data['description'];
        $country -> status = $data['status'];
        $country -> save();
        flash()->success('Thêm quốc gia thành công.');
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
        $country = Country::find($id);
        $list = Country::all();
        return view('admincp.country.form',compact('list', 'country'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|unique:countries|max:255',
            'slug' => 'required|max:255',
            'description' => 'required|max:255',
            'status' => 'required|boolean',
        ],
        [
            'title.unique' => 'Tên quốc gia này đã có,vui lòng điền tên khác.',
            'title.required' => 'Bắt buộc phải điền tên quốc gia.',
            'description.required' => 'Bắt buộc phải điền mô tả.',
        ]
        );
        // $data = $request->all();
        $country = Country::find($id);
        $country -> title = $data['title'];
        $country -> slug = $data['slug'];
        $country -> description = $data['description'];
        $country -> status = $data['status'];
        $country -> save();
        flash()->success('Cập nhật quốc gia thành công.');
        return redirect()->route('country.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        Country::find($id)->delete();
        flash()->info('Xóa quốc gia thành công.');
        return redirect()->back();
    }
}
