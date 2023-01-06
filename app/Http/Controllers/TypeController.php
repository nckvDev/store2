<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function index()
    {
        $types = Type::paginate(100);
        $categorys = Category::all();
        return view('admin.type.index', compact('types', 'categorys'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'type_detail' => 'required|unique:types|max:255',
                'category_id' => 'required'
            ],
            [
                'type_detail.required' => 'กรุณาป้อนชื่อประเภทด้วยครับ',
                'type_detail.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'type_detail.unique' => "มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว",
                'category_id.required' => 'กรุณาเลือกหมวดหมู่ด้วยครับ',
            ]
        );

        Type::insert([
            'type_detail' => $request['type_detail'],
            'category_id' => $request['category_id'],
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $types = Type::find($id);
        return view('admin.type.edit', compact('types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'type_detail' => 'required|max:255'
            ],
            [
                'type_detail.required' => "กรุณาป้อนชื่อภาพด้วยครับ",
                'type_detail.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );

        Type::find($id)->update([
            'type_detail' => $request['type_detail']
        ]);

        return redirect()->route('type')->with('update', 'อัพเดทเรียบร้อย');
    }

    public function delete($id)
    {
        Type::destroy($id);
        return redirect()->back()->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
}
