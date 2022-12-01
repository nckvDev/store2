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
        return Borrow::query()->whereBetween('created_at', [$this->fromDate, $this->toDate ])->orderBy('borrow_status', 'desc');
    }

    public function headings(): array
    {
        // TODO: Implement headings() method.
        return [
            'รหัสอุปกรณ์',
            'ชื่ออุปกรณ์',
            'จำนวน',
            'ชื่อ-นามสกุล',
            'สถานะ',
            'หมายเหตุ',
            'อัพเดทวันที่',
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
                $status = "รออนุมัติขอยืม";
                break;
            case 2:
                $status = "อนุมัติ";
                break;
            case 4:
                $status = "รออนุมัติส่งคืน";
                break;
            case 5:
                $status = "ส่งคืนแล้ว";
                break;
            default:
                $status = "ไม่อนุมัติ";
        }

        return [
            $listId,
            $newName,
            $amount,
            $row->borrow_user->firstname . " " . $row->borrow_user->lastname,
            $status,
            $row->description ?  $row->description : "-",
            $row->created_at
        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
