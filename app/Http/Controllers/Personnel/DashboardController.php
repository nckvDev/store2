<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $user = Auth::user()->id;
        $borrowList = Borrow::where('user_id', $user)->get();
        return view('users.personnel.dashboard', compact('borrowList'));
    }

    public function update() {

    }
}
