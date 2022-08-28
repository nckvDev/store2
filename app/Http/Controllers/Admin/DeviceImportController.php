<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DeviceImport;
use Excel;

class DeviceImportController extends Controller
{
    public function index(){
        return view('admin.device.import');
    }

    public function import(Request $request){
        Excel::import(new DeviceImport,$request->file);
        return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }
}