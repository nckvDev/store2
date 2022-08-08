<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Disposable;
use App\Models\Stock;

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
        $stocks = Stock::paginate();
        $devices = Device::all();
        $disposables = Disposable::all();
        return view('admin.dashboard', compact('stocks', 'devices', 'disposables'));
    }
}
