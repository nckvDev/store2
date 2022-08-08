<?php

namespace App\Http\Controllers\Personnel;

use App\Http\Controllers\Controller;
use App\Models\Device;
use App\Models\Disposable;
use App\Models\Prefix;
use App\Models\Stock;
use App\Models\Type;
use Illuminate\Http\Request;
use DataTables;
use Carbon\Carbon;

class BorrowController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        $types = Type::all();
        $stocks = Stock::all();
        $devices = Device::all();
        $prefixs = Prefix::all();
        $disposables = Disposable::all();

        
        return view('users.personnel.borrow', compact('stocks', 'prefixs' , 'types' , 'devices' , 'disposables'));
    }

    public function cartList()
    {   
        $stocks = Stock::all();
        $devices = Device::all();
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();
        // dd($cartItems);
        return view('users.personnel.borrow', compact('cartItems', 'stocks', 'devices' , 'disposables'));
    }

    public function addToCart(Request $request)
    {
        \Cart::add([
            'device_num' => $request->id,
            'device_name' => $request->name,
            'quantity' => $request->quantity,
            'attributes' => array(
                'image' => $request->image,),

            'stock_num' => $request->id,
            'stock_num_name' => $request->name,
            'quantity' => $request->quantity,
            'attributes' => array(
                    'image' => $request->image,),
                    
            'disposable_num' => $request->id,
            'disposable_name' => $request->name,
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


    
}