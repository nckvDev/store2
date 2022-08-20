<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DataImport;
use Excel;
use App\Models\MasterUser;

class DataImportController extends Controller
{
    public function index(){
        $masterusers = MasterUser::all();
        return view('admin.ImportData.index', compact('masterusers'));
    }

    public function import(Request $request){
        Excel::import(new DataImport,$request->file);
        return redirect()->back()->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }


}