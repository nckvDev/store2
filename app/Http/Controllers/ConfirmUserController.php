<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Conform;

class ConfirmUserController extends Controller
{
    public function index()
    {
        $conforms = Borrow::where('borrow_status', 2)->get();
        return view('admin.form.detail', compact('conforms'));
    }
}
