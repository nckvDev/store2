<?php

namespace App\Http\Controllers;

use App\Exports\DevicesExport;
use App\Models\Device;
use App\Models\Type;
use Carbon\Carbon;
use Haruncpi\LaravelIdGenerator\IdGenerator;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class DeviceController extends Controller
{
    public function index()
    {
        $types = Type::all();
//        $types = DB::table('types')
//            ->orderBy('type_detail', 'asc')
//            ->get();
        $devices = Device::all();
        return view('admin.device.index', compact('devices', 'types'));
    }

    public function add()
    {
        $devices = Device::all();
        $types = Type::all();
        return view('admin.device.add', compact('devices', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'device_name' => 'required|max:255',
            'type_id' => 'required',
            'device_year' => 'required',
            'image' => 'required|mimes:jpg,jpeg,png'
        ],
            [
                'device_name.required' => "กรุณาป้อนชื่ออุปกรณ์ด้วยครับ",
                'device_name.max' => "ห้ามป้อนเกิน 255 ตัวอักษร",
                'type_id.required' => "กรุณาเลือกประเภทด้วยครับ",
                'device_year.required' => "กรุณาป้อนปีด้วยครับ",
                'image.required' => "กรุณาใส่ภาพด้วยครับ",
                'image.mimes' => "ประเภทไฟล์ไม่ถูกต้อง"
            ]);

//        $device_num = IdGenerator::generate(['table' => 'devices', 'field' => 'device_num', 'length' => 7, 'prefix' => 'DV-']);

        $deviceImage = $request->file('image');

        $nameGen = hexdec(uniqid());

        $imgExt = strtolower($deviceImage->getClientOriginalExtension());
        $imgName = $nameGen . '.' . $imgExt;

        $upload_location = 'images/devices/';
        $full_path = $upload_location . $imgName;

        Device::create([
            'device_num' => $request['device_num'],
            'device_name' => $request['device_name'],
            'type_id' => $request['type_id'],
            'device_amount' => $request['device_amount'],
            'image' => $full_path,
            'device_year' => $request['device_year'],
            'created_at' => Carbon::now()
        ]);

        $deviceImage->move($upload_location, $imgName);
        return redirect()->route('device')->with('success', 'บันทึกข้อมูลวัสดุเรียบร้อย');
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
            'device_num' => 'required',
            'device_name' => 'required|max:255',
            'image' => 'mimes:jpg,jpeg,png'
        ],
            [
                'device_num.required' => "กรุณาป้อนรหัสอุปกรณ์ด้วยครับ",
                'device_name.required' => 'กรุณาป้อนชื่อภาพด้วยครับ',
                'device_name.max' => 'ห้ามป้อนเกิน 255 ตัวอักษร',
                'image.mimes' => 'นามสกุลไฟล์ต้องเป็น jpg jpeg png'
            ]);

        $deviceImage = $request->file('image');

        if ($deviceImage) {
            $nameGen = hexdec(uniqid());

            $imgExt = strtolower($deviceImage->getClientOriginalExtension());
            $imgName = $nameGen . '.' . $imgExt;

            $upload_location = 'images/devices/';
            $full_path = $upload_location . $imgName;

            Device::find($id)->update([
                'device_num' => $request['device_num'],
                'device_name' => $request['device_name'],
                'type_id' => $request['type_id'],
                'device_amount' => $request['device_amount'],
                'image' => $full_path,
                'device_year' => $request['device_year'],
                'defective_device' => $request['defective_device'],
                'created_at' => Carbon::now()
            ]);

            $old_image = $request['old_image'];
            if ($old_image == null) {
                $upload_location = 'images/devices/';
                $full_path = $upload_location . $imgName;
                Device::find($id)->update([
                    'image' => $full_path,
                ]);
                $deviceImage->move($upload_location, $imgName);
                return redirect()->route('device')->with('update', 'อัพเดทเรียบร้อย');
            }
//            unlink($old_image);

            $deviceImage->move($upload_location, $imgName);
            return redirect()->route('device')->with('update', 'อัพเดทเรียบร้อย');
        } else {
            Device::find($id)->update([
                'device_num' => $request['device_num'],
                'device_name' => $request['device_name'],
                'type_id' => $request['type_id'],
                'device_amount' => $request['device_amount'],
                'device_year' => $request['device_year'],
                'defective_device' => $request['defective_device'],
                'created_at' => Carbon::now()
            ]);
            return redirect()->route('device')->with('update', 'อัพเดทเรียบร้อย');
        }
    }

    public function delete($id)
    {
//        $img = Device::find($id)->image;
//        unlink($img);

        Device::destroy($id);
        return redirect()->back()->with('success', 'ลบข้อมูลเรียบร้อย');
    }

    public function exportXlsm()
    {
        return Excel::download(new DevicesExport(), 'devices.xlsx');
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
        foreach ($query as $row) {
            // $output.='<option value="'.$row->stock_name.'">'.$row->stock_name.'</option>';
            $img = asset($row->image);
            $path_edit = url('/device/edit/' . $row->id);
            $path_del = url('/device/delete/' . $row->id);
            if ($row->device_status == 0)
                $status = "<div class='rounded text-white bg-green text-center'>พร้อมใช้งาน</div>";
            elseif ($row->device_status == 1)
                $status = "<div class='rounded text-white bg-orange text-center'>รออนุมัติ</div>";
            elseif ($row->device_status == 2)
                $status = "<div class='rounded text-white bg-red text-center'>ถูกยืม</div>";

            echo "<tr>
                        <td>
                            {$row->device_num}
                        </td>
                        <td>
                            {$row->device_name}
                        </td>
                        <td><img src='$img' class='rounded mx-auto d-block' width='80' height='80' /></td>
                        <td class='text-center'>
                         $row->device_amount
                        </td>
                        <td class='text-center'>
                            {$row->device_year}
                        </td>
                        <td class='text-center'>
                            {$status}
                        </td>
                        <td class='text-center'>
                                        <div class='dropdown'>
                                            <a class='btn btn-sm btn-icon-only text-light' href='#' role='button'
                                                data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                <i class='fas fa-ellipsis-v'></i>
                                            </a>
                                            <div class='dropdown-menu dropdown-menu-right dropdown-menu-arrow'>
                                                <a class='dropdown-item'
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
