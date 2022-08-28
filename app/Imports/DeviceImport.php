<?php

namespace App\Imports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DeviceImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Device([
            'device_num' => $row['device_num'],
            'device_name' => $row['device_name'],
            'device_status' => $row['device_status'],
            'type_id' => $row['type_id'],
            'location' => $row['location'],
            'image' => $row['image'],
            'device_year' => $row['device_year'],
            'defective_device' => $row['defective_device'],
        ]);
    }
}