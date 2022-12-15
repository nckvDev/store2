<?php

namespace App\Http\Controllers;

use App\Exports\StocksExport;
use App\Models\Stock;
use App\Models\Type;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    public function index()
    {
        $types = Type::all();
        $types = DB::table('types')
            ->orderBy('type_detail', 'asc')
            ->get();
        $stocks = Stock::all();
        return view('admin.stock.index', compact('stocks', 'types'));
    }

    public function add()
    {
        $stocks = Stock::all();
        $types = Type::all();
        return view('admin.stock.add', compact('stocks', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'stock_name' => 'required|max:255',
                'type_id' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'stock_name.required' => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
                'stock_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'image.required' => "กรุณาใส่ภาพด้วยครับ",
                'type_id.required' => "กรุณาเลือกประเภทด้วยครับ",
                'image.mimes' => "ประเภทไฟล์ไม่ถูกต้อง"
            ]
        );

        $stock_num = IdGenerator::generate(['table' => 'stocks', 'field'=>'stock_num', 'length' => 7, 'prefix' => 'ST-']);
        $stockImage = $request->file('image');

        $nameGen = hexdec(uniqid());

        $imgExt = strtolower($stockImage->getClientOriginalExtension());
        $imgName = $nameGen . '.' . $imgExt;

        $upload_location = 'images/stocks/';
        $full_path = $upload_location . $imgName;

        Stock::create([
            'stock_name' => $request['stock_name'],
            'stock_amount' => $request['stock_amount'],
            'image' => $full_path,
            'type_id' => $request['type_id'],
            'stock_num' =>  $stock_num,
            'created_at' => Carbon::now()
        ]);

        $stockImage->move($upload_location, $imgName);
        return redirect()->route('stock')->with('success', 'บันทึกข้อมูลอุปกรณ์เรียบร้อย');
    }

    public function edit($id)
    {
        $stocks = Stock::find($id);
        $types = Type::all();
        return view('admin.stock.edit', compact('stocks', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'stock_name' => 'required|max:255',
                'image' => 'mimes:jpg,jpeg,png'
            ],
            [
                'stock_name.required' => "กรุณาป้อนชื่อภาพด้วยครับ",
                'stock_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'image.mimes' => "นามสกุลไฟล์ต้องเป็น jpg jpeg png"
            ]
        );

        $stockImage = $request->file('image');

        if ($stockImage) {
            $nameGen = hexdec(uniqid());

            $imgExt = strtolower($stockImage->getClientOriginalExtension());
            $imgName = $nameGen . '.' . $imgExt;

            $upload_location = 'images/stocks/';
            $full_path = $upload_location . $imgName;

            Stock::find($id)->update([
                'stock_num' => $request['stock_num'],
                'stock_name' => $request['stock_name'],
                'stock_amount' => $request['stock_amount'],
                'image' => $full_path,
                'type_id' => $request['type_id'],
                'defective_stock' => $request['defective_stock'],
                'updated_at' => Carbon::now()
            ]);

            $old_image = $request->old_image;
            if ($old_image == null) {
                $upload_location = 'images/stocks/';
                $full_path = $upload_location . $imgName;
                Stock::find($id)->update([
                    'image' => $full_path,
                ]);
                $stockImage->move($upload_location, $imgName);
                return redirect()->route('device')->with('success', 'อัพเดทเรียบร้อย');
            }
//            unlink($old_image);

            $stockImage->move($upload_location, $imgName);

        } else {
            Stock::find($id)->update([
                'stock_num' => $request['stock_num'],
                'stock_name' => $request['stock_name'],
                'stock_amount' => $request['stock_amount'],
                'type_id' => $request['type_id'],
                'defective_stock' => $request['defective_stock'],
                'updated_at' => Carbon::now()
            ]);
        }

        return redirect()->route('stock')->with('success', 'อัพเดทข้อมูลอุปกรณ์เรียบร้อย');
    }

    public function delete($id)
    {
//        $img = Stock::find($id)->image;
//        unlink($img);

        Stock::destroy($id);
        return redirect()->back()->with('delete', 'ลบข้อมุลเรียบร้อย');
    }

    public function exportXlsm()
    {
        return Excel::download(new StocksExport(), 'stocks.xlsx');
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
        foreach ($query as $row) {
            // $output.='<option value="'.$row->stock_name.'">'.$row->stock_name.'</option>';
            $img = asset($row->image);
            $path_edit = url('/stock/edit/' . $row->id);
            $path_del = url('/stock/delete/' . $row->id);
            if ($row->stock_status == 0)
                $status = "<div class='rounded text-white bg-green text-center'>พร้อมใช้งาน</div>";
            elseif ($row->stock_status == 1)
                $status = "<div class='rounded text-white bg-orange text-center'>รออนุมัติ</div>";
            elseif ($row->stock_status == 2)
                $status = "<div class='rounded text-white bg-red text-center'>ถูกยืม</div>";

            echo "<tr>
                        <td>
                            {$row->stock_num}
                        </td>
                        <td>
                            {$row->stock_name}
                        </td>
                        <td><img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
                        <td class='text-center'>
                            {$row->stock_amount}
                        </td>
                        <td>
                            {$status}
                        </td>
                        <td class='text-center'>
                                        <div class='dropdown'>
                                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button'
                                                data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-ellipsis-v'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                                                <a class='dropdown-item''
                                                    href='$path_edit'>แก้ไขข้อมูล</a>
                                                <a class='dropdown-item delete-confirm'
                                                    href='$path_del'>ลบข้อมูล</a>
                                            </div>
                                        </div>
                                    </td>
                    </tr>";
            echo " <script>
                     $('.delete-confirm').on('click', function (event) {
                                event.preventDefault();
                                const url = $(this).attr('href');
                                Swal.fire({
                                    title: 'คุณแน่ใจ?',
                                    text: 'คุณต้องการลบข้อมูลนี้หรือไม่!',
                                    icon: 'warning',
                                    focusCancel: true,
                                    showCancelButton: true,
                                    confirmButtonColor: '#007bff',
                                    cancelButtonColor: '#dc3545',
                                    confirmButtonText: 'ตกลง',
                                    cancelButtonText: 'ยกเลิก'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        window.location.href = url;
                                        Swal.fire({
                                            position: 'center',
                                            icon: 'success',
                                            title: 'ลบข้อมูลเรียบร้อย',
                                            showConfirmButton: false,
                                            timer: 1500
                                        })
                                    }
                                });
                            });
                    </script>";
        }

        echo $output;
    }
}
