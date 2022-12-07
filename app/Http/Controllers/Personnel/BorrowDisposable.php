<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Models\Device;
use App\Models\Stock;
use App\Models\Disposable;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BorrowDisposable extends Controller
{
    public function cartList(Request $request)
    {
        $select_id = intval($request['type']);
        $searchName = $request['name'];

        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();

        if ($select_id != null) {
            $disposables = Disposable::where('type_id', $select_id)->get();
        }

        if ($searchName != null) {
            $disposables = Disposable::where('disposable_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        if ($select_id != null && $searchName != null) {
            $disposables = Disposable::where('type_id', $select_id)->where('disposable_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        return view('users/personnel/borrowDisposable', compact('cartItems', 'disposables', 'types'));
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
        session()->flash('success', 'Product is Added to Cart Successfully !');

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
        session()->flash('success', 'Item Cart is Updated Successfully !');
        return redirect()->back();
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request['id']);
        session()->flash('success', 'Item Cart Remove Successfully !');
        return redirect()->back();
    }

    public function clearAllCart()
    {
        \Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');
        return redirect()->back();
    }

    public function saveCart(Request $request)
    {
        $user_id = Auth::user()['id'];
        $stock_borrow = null;
        $device_borrow = null;
        $borrow_name = '';
        $amount_borrow = 0;
        $num = 0;

        if ($request['borrow_list_id']) {

            for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
                $disposable = DB::table('disposables')->where('disposable_num', $request['borrow_list_id'][$i])->get();
                foreach ($disposable as $item) {
                    $amount_borrow = $item->disposable_amount - $item->amount_minimum;
                }
            }

            for ($i = 0; $i < count($request['borrow_amount']); $i++) {
                $amount = $request['borrow_amount'][$i];
                if (intval($amount) > 1) {
                    $borrow_name = $request['borrow_name'][$i];
                    $num = intval($amount);
                }
            }

            if ($num < $amount_borrow) {
                Borrow::create([
                    'borrow_list_id' => $request['borrow_list_id'],
                    'borrow_name' => $request['borrow_name'],
                    'borrow_status' => $request['borrow_status'],
                    'borrow_amount' => $request['borrow_amount'],
                    'user_id' => $user_id,
                ]);

                \Cart::clear();
                session()->flash('success', 'All Item Cart Clear Successfully !');

                return redirect()->back()->with('successes', 'ยืนยันรายการยืมสำเร็จ');
            } else {
                return redirect()->back()->with('warning', 'จำนวนวัสดุไม่เพียงพอ');
            }
        }
        return redirect()->back()->with('error', 'ไม่มีรายการที่เลือก');
    }
}
