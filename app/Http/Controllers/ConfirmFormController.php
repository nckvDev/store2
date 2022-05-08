<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;

class ConfirmFormController extends Controller
{
    public function index()
    {
        return view('admin.form.index');
    }
}