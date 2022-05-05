<?php

namespace App\Http\Controllers\Personnel;

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

    public function index() {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $prefixs = Prefix::all();
        return view('users.personnel.borrow', compact('stocks', 'prefixs' , 'types' , 'devices'));
    }
}
