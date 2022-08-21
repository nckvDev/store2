<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Conform;

class ConfirmFormController extends Controller
{
    public function index()
    {
        $conforms = Borrow::where('borrow_status',0)->get();
        return view('admin.form.index', compact('conforms'));
    }

    // public function store()
    // {
    //     $conforms = Conform::where('status',1)->get();
    //     return view('admin.form.detail', compact('conforms'));
    // }

    public function create(Request $request)
    {
        MasterUser::create([
            'user_id' => $request->user_id,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
        ]);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

    public function update(Request $request, $id)
    {
        Borrow::find($id)->update([
            'borrow_status' => $request->borrow_status,
        ]);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
