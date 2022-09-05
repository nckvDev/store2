<?php

namespace App\Http\Controllers;

use App\Models\Borrow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmFormController extends Controller
{
    public function index()
    {
        $conforms = Borrow::where('borrow_status', 1)->get();
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
            'borrow_status' => $request['borrow_status'],
        ]);

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                'stock_status' => $request['borrow_status']
            ]);
        }

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('devices')->where('device_num', $request['borrow_list_id'][$i])->update([
                'device_status' => $request['borrow_status']
            ]);
        }

        $borrow_id = Borrow::find($id);
        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            $disposable = DB::table('disposables')->where('disposable_num', $request['borrow_list_id'][$i])->get();
            foreach ($disposable as $item) {
                $dis_amount = $item->disposable_amount - intval($borrow_id['borrow_amount'][$i]);
                DB::table('disposables')->where('disposable_num', $request['borrow_list_id'][$i])->update([
                    'disposable_amount' => $dis_amount
                ]);
            }
        }

        return redirect()->back()->with('success', 'บันทึกข้อมูลเรียบร้อย');
    }
}
