<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $user = Auth::user()->id;
        $borrowList = Borrow::where(['user_id' => $user])->get();
        return view('users.personnel.dashboard', compact('borrowList'));
    }

    public function update(Request $request, $id)
    {
        Borrow::find($id)->update([
            'borrow_status' => $request['borrow_status'],
        ]);

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                'stock_status' => $request['borrow_status']
            ]);
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
