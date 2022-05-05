<?php

namespace App\Http\Controllers;

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
        $stocks = Stock::paginate(5);
        return view('admin.dashboard', compact('stocks'));
//        return view('dashboard');
    }
}