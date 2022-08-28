<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Type;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        $devices = Device::paginate(5);
        return view('admin.device.index', compact('devices'));
    }

    public function add()
    {
        $devices = Device::all();
        $types = Type::all();
        return view('admin.device.add', compact('devices', 'types'));
    }

    public function store(Request $request)
    {
//        dd($request->all());
        $request->validate([
            'device_name' => 'required|unique:devices|max:255',
            'image' => 'required|mimes:jpg,jpeg,png'
        ],
        [
            'device_name.required' => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
            'device_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            'device_name.unique' => "มีข้อมูลชื่อนี้ในฐานข้อมูลแล้ว",
            'image.required' => "กรุณาใส่ภาพด้วยครับ",
            'image.mimes' => "ประเภทไฟล์ไม่ถูกต้อง"
        ]);

        $deviceImage = $request->file('image');

        $nameGen = hexdec(uniqid());

        $imgExt = strtolower($deviceImage->getClientOriginalExtension());
        $imgName = $nameGen . '.' . $imgExt;

        $upload_location = 'images/devices/';
        $full_path = $upload_location . $imgName;

        Device::create([
            'device_num' => $request->device_num,
            'device_name' => $request->device_name,
            'type_id' => $request->type_id,
            'location' => $request->location,
            'image' => $full_path,
            'device_year' => $request->device_year,
            'created_at' => Carbon::now()
        ]);

        $deviceImage->move($upload_location, $imgName);
        return redirect()->back()->with('success', 'บันทึกข้อมูลวัสดุเรียบร้อย');
    }

    public function edit($id)
    {
        $devices = Device::find($id);
        $types = Type::all();
        return view('admin.device.edit', compact('devices', 'types'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
           'device_name' => 'required|max:255',
           'image' => 'mimes:jpg,jpeg,png'
        ],
        [
            'device_name.required' => "กรุณาป้อนชื่อภาพด้วยครับ",
            'device_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
            'image.mimes' => "นามสกุลไฟล์ต้องเป็น jpg jpeg png"
        ]);

        $deviceImage = $request->file('image');

        if ($deviceImage) {
            $nameGen = hexdec(uniqid());

            $imgExt = strtolower($deviceImage->getClientOriginalExtension());
            $imgName = $nameGen . '.' . $imgExt;

            $upload_location = 'images/devices/';
            $full_path = $upload_location . $imgName;

            Device::find($id)->update([
                'device_num' => $request->device_num,
                'device_name' => $request->device_name,
                'type_id' => $request->type_id,
                'location' => $request->location,
                'image' => $full_path,
                'device_year' => $request->device_year,
                'created_at' => Carbon::now()
            ]);

            $old_image = $request->old_image;
            unlink($old_image);

            $deviceImage->move($upload_location, $imgName);
            return redirect()->route('device')->with('success', 'อัพเดทเรียบร้อย');
        } else {
            Device::find($id)->update([
                'device_num' => $request->device_num,
                'device_name' => $request->device_name,
                'type_id' => $request->type_id,
                'location' => $request->location,
                'device_year' => $request->device_year,
                'created_at' => Carbon::now()
            ]);
            return redirect()->route('device')->with('success', 'อัพเดทเรียบร้อย');
        }
    }

    public function delete($id)
    {
        $img = Device::find($id)->image;
        unlink($img);

        Device::destroy($id);
        return redirect()->route('device')->with('success', 'ลบข้อมูลเรียบร้อย');
    }
}