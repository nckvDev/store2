<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Imports\StockImport;
use Excel;

class StockImportController extends Controller
{
    public function index(){
        return view('admin.stock.import');
    }

    public function import(Request $request){
        Excel::import(new StockImport,$request->file);
        return redirect()->route('stock-import')->with('success', 'เพิ่มข้อมูลสำเร็จ');
    }
}