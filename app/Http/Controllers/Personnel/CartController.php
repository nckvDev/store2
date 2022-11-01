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

class CartController extends Controller
{
    public function cartList(Request $request)
    {
        $select_id = intval($request->input('type'));

        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $devices = Device::where('device_status', 0)->where('defective_device', 0)->get();
        $stocks = Stock::where('stock_status', 0)->where('defective_stock', 0)->get();
        $disposables = Disposable::all();
        $cartItems = \Cart::getContent();

        if ($select_id) {
            $devices = Device::where('device_status', 0)->where('defective_device', 0)->where('type_id', $select_id)->get();
            $stocks = Stock::where('stock_status', 0)->where('defective_stock', 0)->where('type_id', $select_id)->get();
            $disposables = Disposable::where('type_id', $select_id)->get();
        }

        return view('users/personnel/cart', compact('cartItems', 'devices', 'stocks', 'disposables', 'types'));
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
        $device_borrow = null;
        $borrow_name = '';
        $amount_borrow = 0;
        $num = 0;

        $request->validate(
            [
                'started_at' => ['required'],
                'end_at' => ['required'],
            ],
            [
                'started_at.required' => "กรุณาป้อนวันที่ยืมด้วยครับ",
                'end_at.required' => "กรุณาป้อนวันที่คืนด้วยครับ",
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
                $device_borrow = DB::table('devices')->where('device_num', $request['borrow_list_id'][$i])->update([
                    'device_status' => 1
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
                    $borrow_name = $request['borrow_name'][$i];
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
            } elseif ($device_borrow) {
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
            ->join('stocks', 'types.id', '=', 'stocks.type_id')
            ->join('disposables', 'types.id', '=', 'disposables.type_id')
            ->select('devices.*','stocks.*','disposables.*')
            ->where('types.id', $id)
            ->get();
        $output = 'ไม่มีข้อมูล';
        foreach ($query as $item) {
            $img = asset($item->image);
            $path_del = url('personnel_borrow/borrow');
            $data = url('personnel_borrow/borrow');
            echo "<tr>

                        <td>
                            <input type='text' value=' $item->device_num ' name='id' readonly>
                        </td>
                        <td>
                            <input type='text' value='$item->device_name' name='name' readonly>
                        </td>
                        <td><img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
                        <td>
                            <input type='text' value='$item->device_amount' name='quantity' readonly>
                        </td>
                        <td>
                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>
                        Launch demo modal
                      </button>


                      <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
                        <div class='modal-dialog modal-dialog-centered' role='document'>
                          <div class='modal-content'>
                          <form action='$path_del' method='POST'enctype='multipart/form-data'>
                          csrf_token();
                            <div class='modal-header'>
                              <h5 class='modal-title' id='exampleModalLongTitle'>Modal title</h5>
                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                                <span aria-hidden='true'>&times;</span>
                              </button>
                            </div>
                            <div class='modal-body'>
                              ...
                            </div>
                            <div class='modal-footer'>
                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                              <button type='submit' class='btn btn-primary'>Save changes</button>
                            </div>
                            </form>
                          </div>
                        </div>
                      </div>
                        </td>
                    </tr>";
        }
        echo $output;
    }
}
