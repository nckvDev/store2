<?php

namespace App\Exports;

use App\Models\Device;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DevicesExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Device::all();
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'id',
            'device_num',
            'device_name',
            'device_status',
            'type_id',
            'device_amount',
            'image',
            'device_year',
            'defective_device',
        ];
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->invoice_number,
            $row->device_num,
            $row->device_name,
            $row->device_status,
            $row->device_type->id,
            $row->device_amount,
            $row->image,
            $row->device_year,
            $row->defective_device,
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'J' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}
