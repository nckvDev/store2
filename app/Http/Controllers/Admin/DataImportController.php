<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DataImport;
use Excel;
use App\Models\Data;

class DataImportController extends Controller
{
    public function index(){
        $datas = Data::all();
        return view('admin.ImportData.index', compact('datas'));
    }

    public function import(Request $request){
        Excel::import(new DataImport,$request->file);
        return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }


}