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
    public function cartList()
    {
        $types = Type::all();
        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $stocks = Stock::all();
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();
        return view('users/student/cart', compact('cartItems', 'stocks', 'disposables', 'types'));
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

        return redirect()->back();
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

        return redirect()->back();
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
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
        $amount_borrow = 0;
        $num = 0;

        $formatTimeStart = strftime('%Y-%m-%d %H:%M', strtotime($request['started_at']));
        $formatTimeEnd = strftime('%Y-%m-%d %H:%M', strtotime($request['end_at']));

        if ($request['borrow_list_id']) {
            for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
                $stock_borrow = DB::table('stocks')->where('stock_num', $request['borrow_list_id'][$i])->update([
                    'stock_status' => 1
                ]);
            }

            for ($i = 0; $i < count($request['borrow_list_id']); $i++) {
                $disposable = DB::table('disposables')->where('disposable_num', $request['borrow_list_id'][$i])->get();
                foreach ($disposable as $item) {
                    $amount_borrow = $item->disposable_amount - $item->amount_minimum;
                }
            }

            for ($i = 0; $i < count($request['borrow_amount']); $i++) {
                $amount = $request['borrow_amount'][$i];
                if (intval($amount) > 1) {
                    $num = intval($amount);
                }
            }

            if($stock_borrow) {
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
            } elseif ($num < $amount_borrow) {
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
            } else {
                return redirect()->back()->with('warning', 'จำนวนวัสดุไม่เพียงพอ');
            }
        }
        return redirect()->back()->with('error', 'ไม่มีรายการที่เลือก');
    }

    public function fetch(Request $request)
    {
        $id = $request->get('select');
        $result = array();
        $query = DB::table('types')
            ->join('devices', 'types.id', '=', 'devices.type_id')
            ->select('devices.*')
            ->where('types.id', $id)
            ->get();
        $output = 'ไม่มีข้อมูล';
        foreach ($query as $item) {
            // $output.='<option value="'.$row->stock_name.'">'.$row->stock_name.'</option>';
            $img = asset($item->image);
            echo "<tr>
                <form action='{{ route('cart.store') }}' method='POST' enctype='multipart/form-data'>
                                    @csrf
                                    <td><input type='text' value='{{ $item->device_num }}' name='id' readonly>
                            </td>
                            <td><input type='text' value='{{ $item->device_name }}' name='name' readonly>
                            </td>
                        <td><img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
                        <td>
                                        <input type='text' value='{{ $item->device_amount }}' name='quantity' readonly>
                                    </td>
                        <td>
                            <button class='btn btn-primary btn-sm'>เลือก</button>
                        </td>
                        </form>
                    </tr>";
        }

        echo $output;
    }
}