<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\DisposableImport;
use Excel;

class DisposableImportController extends Controller
{
    public function index(){
        return view('admin.disposable.import');
    }

    public function import(Request $request){
        Excel::import(new DisposableImport,$request->file);
        return redirect()->route('disposable-import')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }
}