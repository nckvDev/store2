<?php

namespace App\Exports;

use App\Models\MasterUser;
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

class DataExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return MasterUser::all();
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'id',
            'user_id',
            'firstname',
            'lastname',
            'created_at',
            'updated_at',
           
        ];
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->invoice_number,
            $row->user_id,
            $row->firstname,
            $row->lastname,
           
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }

//    public function bindValue(Cell $cell, $value)
//    {
//        // TODO: Implement bindValue() method.
//    }
}