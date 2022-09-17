<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Disposable;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Support\Facades\Session;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
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
