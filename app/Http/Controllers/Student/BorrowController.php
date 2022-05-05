<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Prefix;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Http\Request;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $prefixs = Prefix::all();

        if($request) {
//            $stocks = Stock::find($request->filter, 'type_id');
        }

        return view('users.student.borrow', compact('types', 'stocks', 'prefixs', 'devices'));
    }
}
