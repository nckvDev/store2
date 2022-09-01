<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Department;

class DepartmentController extends Controller
{
    public function index(){
        $departments = Department::paginate(10);
        return view('admin.department.index', compact('departments'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'department_name' => 'required|unique:departments|max:255'
            ],
            [
                'department_name.required' => 'กรุณาป้อนชื่อแผนก',
                'department_name.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'department_name.unique'   => "มีข้อมูลชื่อบริการนี้ในฐานข้อมูลแล้ว"
            ]
        );

        Department::insert([
           'department_name' => $request->department_name,
           'created_at'  => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $departments = Department::find($id);
        return view('admin.department.edit', compact('departments'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'department_name'  => 'required|max:255','unique:departments'
            ],
            [
                'department_name.required' => "กรุณาป้อนชื่อรูปภาพ",
                'department_name.max'      => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );

        Department::find($id)->update([
            'department_name' => $request->department_name
        ]);

        return redirect()->route('department')->with('update', 'อัพเดทเรียบร้อย');
    }

    public function delete($id)
    {
        Department::destroy($id);
        return redirect()->route('department')->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
    
}