<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Stock;
use App\Models\Disposable;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    public function cartList()
    {
        $devices = Device::all();
        $stocks = Stock::all();
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();
        return view('users/personnel/cart', compact('cartItems', 'devices', 'stocks', 'disposables'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,
            )
        ]);
        session()->flash('success', 'Product is Added to Cart Successfully !');

        return redirect()->route('cart.list');
    }

    public function updateCart(Request $request)
    {
        \Cart::update(
            $request->id,
            [
                'quantity' => [
                    'relative' => false,
                    'value' => $request->quantity
                ],
            ]
        );

        session()->flash('success', 'Item Cart is Updated Successfully !');

        return redirect()->route('cart.list');
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
        session()->flash('success', 'Item Cart Remove Successfully !');

        return redirect()->route('cart.list');
    }

    public function clearAllCart()
    {
        \Cart::clear();

        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect()->route('cart.list');
    }

    public function saveCart(Request $request)
    {
        $user_id = Auth::user()['id'];
//        dd($request['borrow_amount']);
        Borrow::create([
            'borrow_list_id' => $request['borrow_list_id'],
            'borrow_name' => $request['borrow_name'],
            'borrow_status' => $request['borrow_status'],
            'borrow_amount' => $request['borrow_amount'],
            'user_id' => $user_id,
        ]);

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                'stock_status' => 1
            ]);
        }

        for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
            DB::table('devices')->where('device_num', $request['borrow_list_id'][$i])->update([
                'device_status' => 1
            ]);
        }


        \Cart::clear();
        session()->flash('success', 'All Item Cart Clear Successfully !');

        return redirect('personnel_borrow')->with('successes', 'ยืนยันรายการยืมสำเร็จ');

    }
}
