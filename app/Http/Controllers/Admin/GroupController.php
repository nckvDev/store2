<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Group;
use App\Models\Department;

class GroupController extends Controller
{
    public function index(){
        $groups = Group::paginate(10);
        $departments = Department::all();
        return view('admin.group.index', compact('groups','departments'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'group_name' => 'required|unique:groups|max:255'
            ],
            [
                'group_name.required' => 'กรุณาป้อนชื่อแผนก',
                'group_name.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'group_name.unique'   => "มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว"
            ]
        );
        
        Group::insert([
           'group_name' => $request->group_name,
           'department_name' => $request->department_name,
           'created_at'  => Carbon::now()
        ]);
        
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $groups = Group::find($id);
        $departments = Department::all();
        return view('admin.group.edit', compact('groups','departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'group_name'  => 'required|max:255'
            ],
            [
                'group_name.required' => "กรุณาป้อนชื่อรูปภาพ",
                'group_name.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );
        
        Group::find($id)->update([
            'group_name' => $request->group_name,
            'department_name' => $request->department_name,
        ]);
        

        return redirect()->route('group')->with('update', 'อัพเดทเรียบร้อย');
    }

    public function delete($id)
    {
        Group::destroy($id);
        return redirect()->route('group')->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
}