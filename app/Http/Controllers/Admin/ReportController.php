<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Stock;

class ReportController extends Controller
{
  public function index()
  {
      //
      $stocks = Stock::all();
      return view('admin.report.index', compact('stocks'));
  }
}
