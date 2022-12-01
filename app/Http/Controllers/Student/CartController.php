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
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();

        if ($select_id != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->get();
            $disposables = Disposable::where('type_id', $select_id)->get();
        }

        if ($searchName != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
            $disposables = Disposable::where('disposable_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        if ($select_id != null && $searchName != null) {
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
            $disposables = Disposable::where('type_id', $select_id)->where('disposable_name', 'LIKE', "%" . $searchName . "%")->get();
        }
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
        session()->flash('success', 'เพิ่มอุปกรณ์ในรายการ');

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

        session()->flash('success', 'อัพเดทรายการอุปกรณ์');

        return redirect()->back();
    }

    public function removeCart(Request $request)
    {
        \Cart::remove($request->id);
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
            ->join('stocks', 'types.id', '=', 'stocks.type_id')
            ->select('stocks.*')
            ->where('types.id', $id)
            ->get();
        $output = 'ไม่มีข้อมูล';
        foreach ($query as $item) {
            // $output.='<option value="'.$row->stock_name.'">'.$row->stock_name.'</option>';
            $img = asset($item->image);
            echo "
                <tr>
                    <form action='{{ route('cart.store') }}' method='POST' enctype='multipart/form-data'>
                        @csrf
                        <td>
                            <input type='text' value='{{ $item->device_num }}' name='id' readonly>
                        </td>
                        <td>
                            <input type='text' value='{{ $item->device_name }}' name='name' readonly>
                        </td>
                        <td>
                            <img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
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
