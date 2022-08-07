<?php

namespace App\Http\Controllers;

use App\Exports\StocksExport;
use App\Exports\UsersExport;
use App\Models\Stock;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StockController extends Controller
{
    public function index()
    {
        $stocks = Stock::paginate(5);
        return view('admin.stock.index', compact('stocks'));
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
                'stock_num'  => 'required|unique:stocks|max:5',
                'stock_name' => 'required|unique:stocks|max:255',
                'type_id' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'stock_num.required'     => "กรุณาป้อนรหัสด้วยครับ",
                'stock_num.max'          => "ห้ามป้อนเกิน 5 ตัว",
                'stock_num.unique'       => "มีข้อมูลรหัสนี้ในฐานข้อมูลแล้ว",
                'stock_name.required'     => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
                'stock_name.max'          => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'stock_name.unique'       => "มีข้อมูลชื่อนี้ในฐานข้อมูลแล้ว",
                'image.required'    => "กรุณาใส่ภาพด้วยครับ",
                'image.mimes'       => "ประเภทไฟล์ไม่ถูกต้อง"
            ]
        );

        $stockImage = $request->file('image');

        $nameGen = hexdec(uniqid());

        $imgExt = strtolower($stockImage->getClientOriginalExtension());
        $imgName = $nameGen . '.' . $imgExt;

        $upload_location = 'images/stocks/';
        $full_path = $upload_location . $imgName;

        Stock::create([
            'stock_name' => $request->stock_name,
            'stock_amount' => $request->stock_amount,
            'image' => $full_path,
            'position' => $request->position,
            'amount_minimum' => $request->amount_minimum,
            'type_id' => $request->type_id,
            'stock_num' => $request->stock_num,
            'created_at' => Carbon::now()
        ]);

        $stockImage->move($upload_location, $imgName);
        return redirect()->back()->with('success', 'บันทึกข้อมูลอุปกรณ์เรียบร้อย');
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
                'stock_num' => $request->stock_num,
                'stock_name' => $request->stock_name,
                'stock_amount' => $request->stock_amount,
                'image' => $full_path,
                'position' => $request->position,
                'amount_minimum' => $request->amount_minimum,
                'type_id' => $request->type_id,
                'defective_stock' => $request->defective_stock,
                'updated_at'    => Carbon::now()
            ]);

            $old_image = $request->old_image;
            unlink($old_image);

            $stockImage->move($upload_location, $imgName);

        } else {
            Stock::find($id)->update([
                'stock_num' => $request->stock_num,
                'stock_name' => $request->stock_name,
                'stock_amount' => $request->stock_amount,
                'position' => $request->position,
                'amount_minimum' => $request->amount_minimum,
                'type_id' => $request->type_id,
                'defective_stock' => $request->defective_stock,
                'updated_at'    => Carbon::now()
            ]);
        }

        return redirect()->route('stock')->with('success', 'อัพเดทข้อมูลอุปกรณ์เรียบร้อย');
    }

    public function delete($id)
    {
        $img = Stock::find($id)->image;
        unlink($img);

        Stock::destroy($id);
        return redirect()->route('stock')->with('delete', 'ลบข้อมุลเรียบร้อย');
    }

    public function exportXlsm()
    {
        return Excel::download(new StocksExport(), 'stocks.xlsx');
    }
}
