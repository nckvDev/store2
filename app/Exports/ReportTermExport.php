<?php

namespace App\Exports;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithCustomValueBinder;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Cell\Cell;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ReportTermExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    public function forTerm(string $fromDate, string $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;

        return $this;
    }

    public function query()
    {
        // TODO: Implement query() method.
        return Borrow::query()->whereBetween('created_at', [$this->fromDate, $this->toDate ]);
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
