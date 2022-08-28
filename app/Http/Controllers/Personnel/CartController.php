<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Device;
use App\Models\Stock;
use App\Models\Disposable;
use App\Models\Borrow;
use Illuminate\Support\Facades\Auth;

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
        $user_id = Auth::user()->id;

        Borrow::create([
            'borrow_id' => [$request->borrow_id],
            'borrow_name' => [$request->borrow_name],
            'user_id' => $user_id,
        ]);

        return redirect('personnel_borrow')->with('successes', 'ยืนยันรายการยืมสำเร็จ');

    }
}
