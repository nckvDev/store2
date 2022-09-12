<?php

namespace App\Exports;

use App\Models\Borrow;
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

class ReportMonthExport implements FromCollection, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Borrow::whereYear('created_at',now()->year)
        ->whereMonth('created_at',now()->month)
        ->get();  
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'id',
            'borrow_list_id',
            'borrow_name',
            'borrow_status',
            'borrow_amount',
            'user_id',
            'created_at',
            'updated_at',
        ];
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        return [
            $row->invoice_number,
            $row->borrow_list_id,
            $row->borrow_name,
            $row->borrow_status,
            $row->borrow_amount,
            $row->borrow_user->user_id,
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}