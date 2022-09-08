<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Stock;
use App\Models\Type;
use App\Models\Disposable;
use Illuminate\Support\Facades\Session;

class DashboardControlle extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $disposables = Disposable::all();

        foreach ($disposables as $item) {
            if ($item->disposable_amount <= $item->amount_minimum) {
                Session::flash('message', "จำนวน {$item->disposable_name} เหลือน้อยแล้ว!!");
                Session::flash('status', 'เหลือน้อย');
                Session::flash('list', '1');
            }
        }
        return view('admin.dashboard', compact('stocks', 'disposables', 'types', 'devices'));
    }
}
