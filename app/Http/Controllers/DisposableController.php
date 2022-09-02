<?php

namespace App\Http\Controllers;

use App\Models\Disposable;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DisposableController extends Controller
{
    public function index()
    {
        $disposables = Disposable::paginate(5);
        return view('admin.disposable.index', compact('disposables'));
    }

    public function add()
    {
        $disposables = Disposable::all();
        $types = Type::all();
        return view('admin.disposable.add', compact('disposables', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'disposable_num'  => 'required|unique:disposables|max:5',
                'disposable_name' => 'required|unique:disposables|max:255',
                'type_id' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'disposable_num.required'     => "กรุณาป้อนรหัสด้วยครับ",
                'disposable_num.max'          => "ห้ามป้อนเกิน 5 ตัว",
                'disposable_num.unique'       => "มีข้อมูลรหัสนี้ในฐานข้อมูลแล้ว",
                'disposable_name.required'     => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
                'disposablek_name.max'          => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'disposable_name.unique'       => "มีข้อมูลชื่อนี้ในฐานข้อมูลแล้ว",
                'image.required'    => "กรุณาใส่ภาพด้วยครับ",
                'image.mimes'       => "ประเภทไฟล์ไม่ถูกต้อง"
            ]
        );

        $disposableImage = $request->file('image');

        $nameGen = hexdec(uniqid());

        $imgExt = strtolower($disposableImage->getClientOriginalExtension());
        $imgName = $nameGen . '.' . $imgExt;

        $upload_location = 'images/disposables/';
        $full_path = $upload_location . $imgName;

        Disposable::create([
            'disposable_name' => $request->disposable_name,
            'disposable_amount' => $request->disposable_amount,
            'image' => $full_path,
            'amount_minimum' => $request->amount_minimum,
            'type_id' => $request->type_id,
            'disposable_num' => $request->disposable_num,
            'created_at' => Carbon::now()
        ]);

        $disposableImage->move($upload_location, $imgName);
        return redirect()->route('disposable')->with('success', 'บันทึกข้อมูลอุปกรณ์เรียบร้อย');
    }

    public function edit($id)
    {
        $disposables = Disposable::find($id);
        $types = Type::all();
        return view('admin.disposable.edit', compact('disposables', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'disposable_num'  => 'required|max:5',
                'disposable_name' => 'required|max:255',
                'type_id' => 'required',
                'image' => 'required|mimes:jpg,jpeg,png'
            ],
            [
                'disposable_num.required'     => "กรุณาป้อนรหัสด้วยครับ",
                'disposable_num.max'          => "ห้ามป้อนเกิน 5 ตัว",
                'disposable_num.unique'       => "มีข้อมูลรหัสนี้ในฐานข้อมูลแล้ว",
                'disposable_name.required'     => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
                'disposable_name.max'          => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'disposable_name.unique'       => "มีข้อมูลชื่อนี้ในฐานข้อมูลแล้ว",
                'image.required'    => "กรุณาใส่ภาพด้วยครับ",
                'image.mimes'       => "ประเภทไฟล์ไม่ถูกต้อง"
            ]
        );

        $disposableImage = $request->file('image');

        if ($disposableImage) {
            $nameGen = hexdec(uniqid());

            $imgExt = strtolower($disposableImage->getClientOriginalExtension());
            $imgName = $nameGen . '.' . $imgExt;

            $upload_location = 'images/disposables/';
            $full_path = $upload_location . $imgName;

            Disposable::find($id)->update([
                'disposable_num' => $request->disposable_num,
                'disposable_name' => $request->disposable_name,
                'disposable_amount' => $request->disposable_amount,
                'image' => $full_path,
                'amount_minimum' => $request->amount_minimum,
                'type_id' => $request->type_id,
                'updated_at'    => Carbon::now()
            ]);

            $old_image = $request->old_image;
            if($old_image == null){
                $upload_location = 'images/disposables/';
                $full_path = $upload_location . $imgName;
                Disposable::find($id)->update([
                    'image' => $full_path,
                ]);
                $deviceImage->move($upload_location, $imgName);
                return redirect()->route('device')->with('success', 'อัพเดทเรียบร้อย');
            }
            unlink($old_image);

            $disposableImage->move($upload_location, $imgName);

        } else {
            Disposable::find($id)->update([
                'disposable_num' => $request->disposable_num,
                'disposable_name' => $request->disposable_name,
                'disposable_amount' => $request->disposable_amount,
                'amount_minimum' => $request->amount_minimum,
                'type_id' => $request->type_id,
                'updated_at'    => Carbon::now()
            ]);
        }

        return redirect()->route('disposable')->with('success', 'อัพเดทข้อมูลอุปกรณ์เรียบร้อย');
    }

    public function delete($id)
    {
        $img = Disposable::find($id)->image;
        unlink($img);

        Disposable::destroy($id);
        return redirect()->route('disposable')->with('delete', 'ลบข้อมุลเรียบร้อย');
    }
}