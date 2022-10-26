<?php

namespace App\Exports;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
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

class ReportMonthExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;

    public function forMonth(string $month) {
        $this->month = $month;

        return $this;
    }

    public function query()
    {
        // TODO: Implement query() method.
        return Borrow::query()->whereMonth('created_at', $this->month);
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
            'user_borrow',
            'description',
            'created_at',
        ];
    }

    public function map($row): array
    {
        // TODO: Implement map() method.
        $name = [];
        $newName = "";
        $status = "";
        $description = "";
        $listId = "";
        $amount = "";

        if($row) {
            foreach ($row->borrow_name as $item) {
                $name[] = json_decode('"'.$item.'"');
            }
        }
        $newName = join(", ", $name);
        $listId = join(", ", $row->borrow_list_id);
        $amount = join(", ", $row->borrow_amount);

        switch ($row->borrow_status) {
            case 1:
                $status = "รออนุมัติ";
                break;
            case 2:
                $status = "อนุมัติ";
                break;
            default:
                $status = "ไม่อนุมัติ";
        }

        return [
            $row->invoice_number,
            $listId,
            $newName,
            $amount,
            $row->borrow_user->firstname,
            $status,
            $row->description ?  $row->description : "-",
            $row->created_at
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'H' => NumberFormat::FORMAT_DATE_DDMMYYYY
        ];
    }
}
