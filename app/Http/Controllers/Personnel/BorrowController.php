<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use App\Models\Device;
use App\Models\Disposable;
use App\Models\Prefix;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

//    public function index() {
//        $types = Type::all();
//        $stocks = Stock::all();
//        $devices = Device::all();
//        $prefixs = Prefix::all();
//        $disposables = Disposable::all();
//
//        return view('users.personnel.borrow', compact('stocks', 'prefixs' , 'types' , 'devices' , 'disposables'));
//    }

    public function borrow()
    {
//        $borrows = Borrow::where('borrow_status', 0);
//        return view('users.personnel.');
    }
}
