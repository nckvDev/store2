<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManageLocationController extends Controller
{
    //
    public function index()
    {
        return view('admin.LocationManage.index');
    }
}
