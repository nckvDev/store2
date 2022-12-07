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
        $select_id = intval($request['type']);
        $searchName = $request['name'];

        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $devices = Device::whereIn('device_status', [0, 3, 5])->where('defective_device', 0)->get();
        $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->get();
        $cartItems = \Cart::getContent();

        if ($select_id != null) {
            $devices = Device::whereIn('device_status', [0, 3, 5])->where('defective_device', 0)->where('type_id', $select_id)->get();
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->get();
        }

        if ($searchName != null) {
            $devices = Device::whereIn('device_status', [0, 3, 5])->where('defective_device', 0)->where('device_name', 'LIKE', "%" . $searchName . "%")->get();
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        if ($select_id != null && $searchName != null) {
            $devices = Device::whereIn('device_status', [0, 3, 5])->where('defective_device', 0)->where('type_id', $select_id)->where('device_name', 'LIKE', "%" . $searchName . "%")->get();
            $stocks = Stock::whereIn('stock_status', [0, 3, 5])->where('defective_stock', 0)->where('type_id', $select_id)->where('stock_name', 'LIKE', "%" . $searchName . "%")->get();
        }

        return view('users/personnel/cart', compact('cartItems', 'devices', 'stocks', 'types'));
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
                $device_borrow = DB::table('devices')->where('device_num', $request['borrow_list_id'][$i])->update([
                    'device_status' => 1
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
            }
        }
        return redirect()->back()->with('error', 'ไม่มีรายการที่เลือก');
    }

//    public function fetch(Request $request)
//    {
//        $id = $request->get('select');
//        $result = array();
//        $query = DB::table('types')
//            ->join('devices', 'types.id', '=', 'devices.type_id')
//            ->join('stocks', 'types.id', '=', 'stocks.type_id')
//            ->join('disposables', 'types.id', '=', 'disposables.type_id')
//            ->select('devices.*','stocks.*','disposables.*')
//            ->where('types.id', $id)
//            ->get();
//        $output = 'ไม่มีข้อมูล';
//        foreach ($query as $item) {
//            $img = asset($item->image);
//            $path_del = url('personnel_borrow/borrow');
//            $data = url('personnel_borrow/borrow');
//            echo "<tr>
//
//                        <td>
//                            <input type='text' value=' $item->device_num ' name='id' readonly>
//                        </td>
//                        <td>
//                            <input type='text' value='$item->device_name' name='name' readonly>
//                        </td>
//                        <td><img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
//                        <td>
//                            <input type='text' value='$item->device_amount' name='quantity' readonly>
//                        </td>
//                        <td>
//                        <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#exampleModalCenter'>
//                        Launch demo modal
//                      </button>
//
//
//                      <div class='modal fade' id='exampleModalCenter' tabindex='-1' role='dialog' aria-labelledby='exampleModalCenterTitle' aria-hidden='true'>
//                        <div class='modal-dialog modal-dialog-centered' role='document'>
//                          <div class='modal-content'>
//                          <form action='$path_del' method='POST'enctype='multipart/form-data'>
//                          csrf_token();
//                            <div class='modal-header'>
//                              <h5 class='modal-title' id='exampleModalLongTitle'>Modal title</h5>
//                              <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
//                                <span aria-hidden='true'>&times;</span>
//                              </button>
//                            </div>
//                            <div class='modal-body'>
//                              ...
//                            </div>
//                            <div class='modal-footer'>
//                              <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
//                              <button type='submit' class='btn btn-primary'>Save changes</button>
//                            </div>
//                            </form>
//                          </div>
//                        </div>
//                      </div>
//                        </td>
//                    </tr>";
//        }
//        echo $output;
//    }
}
