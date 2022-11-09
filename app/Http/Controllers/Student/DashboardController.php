<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user()->id;
        $borrowList = Borrow::where(['user_id' => $user])->latest()->get();
        return view('users.student.dashboard', compact('borrowList'));
    }

    public function update(Request $request, $id)
    {
        $status = null;

        if ($request['borrow_status'] == 4) {
            $status = 0;
        } else {
            $status = $request['borrow_status'];
        }

        Borrow::find($id)->update([
            'borrow_status' => $request['borrow_status'],
        ]);

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                'stock_status' => $status
            ]);
        }

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('devices')->where('device_num', $request['borrow_list_id'][$i])->update([
                'device_status' => $status
            ]);
        }

        return redirect()->back()->with('success', 'ส่งคืนรายการเรียบร้อย');
    }
}
