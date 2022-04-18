<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Stock;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $stocks = Stock::all();
        return view('users.personnel.borrow', compact('stocks'));
    }
}
