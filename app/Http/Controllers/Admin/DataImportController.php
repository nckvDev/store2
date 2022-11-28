<?php

namespace App\Http\Controllers\Admin;

use App\Exports\DataExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DataImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\MasterUser;
use Carbon\Carbon;

class DataImportController extends Controller
{
    public function index()
    {
        $masterusers = MasterUser::all();
        return view('admin.ImportData.index', compact('masterusers'));
    }

    public function import(Request $request)
    {
        Excel::import(new DataImport, $request->file);
        return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }

    public function exportXlsm()
    {
        return Excel::download(new DataExport(), 'users.xlsx');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'user_id' => 'required|unique:master_users|max:255'
            ],
            [
                'user_id.required' => 'กรุณาป้อนรหัสผู้ใช้งาน',
                'user_id.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'user_id.unique' => "มีข้อมูลรหัสนี้ในฐานข้อมูลแล้ว"
            ]
        );

        MasterUser::insert([
            'user_id' => $request['user_id'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'created_at' => Carbon::now()
        ]);

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $masterUsers = MasterUser::find($id);
        return view('admin.ImportData.edit', compact('masterUsers'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'user_id' => 'required|max:255', 'unique:master_users'
            ],
            [
                'user_id.required' => "กรุณาป้อนชื่อรูปภาพ",
                'user_id.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            ]
        );

        MasterUser::find($id)->update([
            'user_id' => $request['user_id'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
        ]);

        return redirect()->route('data-import')->with('update', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function delete($id)
    {
        MasterUser::destroy($id);
        return redirect()->back()->with('delete', 'ลบข้อมูลเรียบร้อย');
    }
}
