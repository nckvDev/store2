<?php

namespace App\Http\Controllers\Admin;

use App\Models\Department;
use App\Models\Group;
use App\Models\Prefix;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ManageRoleController extends Controller
{
    public function index()
    {
        $users = DB::table('users')
             ->join('prefixes', 'users.prefix_id', '=', 'prefixes.id')
             ->select('users.*','prefixes.prefix_name')
             ->get();
        return view('admin.ManageRole.index', compact('users'));
    }

    public function update(Request $request, $id){
        User::find($id)->update([
            'user_id' => $request['user_id'],
            'firstname' => $request['firstname'],
            'lastname' => $request['lastname'],
            'prefix_id' => $request['prefix_id'],
            'email' => $request['email'],
            'department' => $request['department'],
            'group' => $request['group'],
            'role' => $request['role'],
        ]);
        return redirect('manage-role')->with('success', 'แก้ไขข้อมูลเรียบร้อย');
    }

    public function edit($id)
    {
        $groups = Group::all();
        $departments = Department::all();
        $prefixes = Prefix::all();
        $users = User::find($id);
        return view('admin.ManageRole.edit', compact('users', 'departments', 'groups', 'prefixes'));
    }

    public function delete($id)
    {
        User::destroy($id);
        return redirect()->back()->with('delete', 'ลบข้อมุลเรียบร้อย');
    }

}
