<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersExport implements FromCollection, WithHeadings, ShouldAutoSize, WithMapping, WithColumnFormatting
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return User::all();
    }

    public function headings(): array
    {
        return [
            'Prefix',
            'FirstName',
            'LastName',
            'Email',
            'Role',
            'Created',
        ];
    }

    /**
     * @var Invoice $invoice
     */
    public function map($invoice): array
    {
        return [
            $invoice->user_prefix->prefix_name,
            $invoice->firstname,
            $invoice->lastname,
            $invoice->email,
            $invoice->role,
            Date::dateTimeToExcel($invoice->created_at),
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'F' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}