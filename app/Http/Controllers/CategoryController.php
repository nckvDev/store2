<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categorys = Category::paginate(5);
        return view('admin.category.index', compact('categorys'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'category_detail' => 'required|unique:categorys|max:255'
            ],
            [
                'category_detail.required' => 'กรุณาป้อนชื่อประเภทด้วยครับ',
                'category_detail.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'category_detail.unique'   => "มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว"
            ]
        );

        Category::insert([
           'category_detail' => $request['category_detail'],
           'created_at'  => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $categorys = Category::find($id);
        return view('admin.category.edit', compact('categorys'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'category_detail'  => 'required|max:255'
            ],
            [
                'category_detail.required' => "กรุณาป้อนชื่อภาพด้วยครับ",
                'category_detail.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );

        Category::find($id)->update([
            'category_detail' => $request['category_detail']
        ]);

        return redirect()->route('category')->with('update', 'อัพเดทเรียบร้อย');
    }

    public function delete($id)
    {
        Category::destroy($id);
        return redirect()->back()->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
}
