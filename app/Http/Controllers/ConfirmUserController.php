<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Conform;

class ConfirmUserController extends Controller
{
    public function index()
    {
        $conforms = Conform::where('status',1)->get();
        return view('admin.form.detail', compact('conforms'));
    }
}