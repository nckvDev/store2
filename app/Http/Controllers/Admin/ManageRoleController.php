<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ManageRoleController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('admin.ManageRole.index', compact('users'));
    }

    public function update(Request $request, $id){
        User::find($id)->update([
            'role' => $request->role,
        ]);
        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }

}