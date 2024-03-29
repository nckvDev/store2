<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Stock;
use App\Models\Disposable;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cartList(Request $request)
    {
        $select_id = intval($request->input('type'));
        $searchName = $request['name'];

        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->get();
        $cartItems = \Cart::getContent();

        if ($select_id != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->get();
        }

        if ($searchName != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        if ($select_id != null && $searchName != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
        }
        return view('users/student/cart', compact('cartItems', 'stocks', 'types'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request['id'],
            'name' => $request['name'],
            'price' => $request['price'],
            'quantity' => $request['quantity'],
//            'attributes' => array(
//                'image' => $request->image,
//            )
        ]);
        session()->flash('success', 'เพิ่มอุปกรณ์ในรายการ');

        return redirect()->back();
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request['id'],
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request['quantity']
                ],
            ]
        );
        session()->flash('success', 'อัพเดทรายการอุปกรณ์');
        return redirect()->back();
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request['id']);
        session()->flash('success', 'ลบรายการที่เลือก');
        return redirect()->back();
    }

    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'ลบรายการที่เลือกทั้งหมด');
        return redirect()->back();
    }

    public function saveCart(Request $request)
    {
        $user_id = Auth::user()['id'];
        $stock_borrow = null;
        $amount_borrow = 0;
        $num = 0;

        $request->validate(
            [
                'started_at' => ['required'],
                'end_at' => ['required'],
            ],
            [
                'started_at.required' => "กรุณาป้อนวันที่ยืม",
                'end_at.required' => "กรุณาป้อนวันที่คืน",
            ]
        );

        $formatTimeStart = strftime('%Y-%m-%d %H:%M', strtotime($request['started_at']));
        $formatTimeEnd = strftime('%Y-%m-%d %H:%M', strtotime($request['end_at']));

        if ($request['borrow_list_id']) {
            for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
                $stock_borrow = DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                    'stock_status' => 1
                ]);
            }

            if ($stock_borrow) {
                Borrow::create([
                    'borrow_list_id' => $request['borrow_list_id'],
                    'borrow_name' => $request['borrow_name'],
                    'borrow_status' => $request['borrow_status'],
                    'borrow_amount' => $request['borrow_amount'],
                    'user_id' => $user_id,
                    'started_at' => $formatTimeStart,
                    'end_at' => $formatTimeEnd,
                ]);
                \Cart::clear();
                session()->flash('success', 'All Item Cart Clear Successfully !');
                return redirect()->back()->with('successes', 'ยืนยันรายการยืมสำเร็จ');
            }
        }
        return redirect()->back()->with('error', 'ไม่มีรายการที่เลือก');
    }
}
