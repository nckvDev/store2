<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Prefix;

class PrefixController extends Controller
{
    public function index(){
        $prefixs = Prefix::paginate(10);
        return view('admin.prefix.index', compact('prefixs'));
    }

    public function store(Request $request)
    {   
        Prefix::insert([
           'prefix_name' => $request->prefix_name,
           'created_at'  => Carbon::now()
        ]);
        
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $prefixs = Prefix::find($id);
        return view('admin.prefix.edit', compact('prefixs'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'prefix_name'  => 'required|max:255'
            ],
            [
                'prefix_name.required' => "กรุณาป้อนชื่อรูปภาพ",
                'prefix_name.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );
        
        Prefix::find($id)->update([
            'prefix_name' => $request->prefix_name,
        ]);

        return redirect()->route('prefix')->with('update', 'อัพเดทเรียบร้อย');
    }

    public function delete($id)
    {
        Prefix::destroy($id);
        return redirect()->route('prefix')->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
}