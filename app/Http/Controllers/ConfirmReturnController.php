<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmReturnController extends Controller
{
    public function index()
    {
        $returns = Borrow::where('borrow_status', 4)->get();
        return view('admin.form.return', compact('returns'));
    }

    public function update(Request $request, $id)
    {
        $status = null;

        if($request['borrow_status'] == 6 ) {
            $status = 2;
        } else {
            $status = $request['borrow_status'];
        }

        Borrow::find($id)->update([
            'borrow_status' => $request['borrow_status'],
            'description' => $request['description']
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

        if($request['borrow_status'] == 5 ) {
            return redirect()->back()->with('success', 'ส่งคืนเรียบร้อย');
        }

        return redirect()->back()->with('error', 'ยกเลิกรายการยืมสำเร็จ');
    }
}
