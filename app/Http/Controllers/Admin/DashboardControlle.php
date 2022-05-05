<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Stock;
use App\Models\Type;
use App\Models\Disposable;
use Illuminate\Http\Request;

class DashboardControlle extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $disposables = Disposable::all();
        return view('admin.dashboard', compact('stocks','disposables', 'types' , 'devices'));
    }
}