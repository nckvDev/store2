<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Prefix;
use App\Models\Stock;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $stocks = Stock::all();
        $prefixs = Prefix::all();
        return view('users.student.borrow', compact('stocks', 'prefixs'));
    }
}
