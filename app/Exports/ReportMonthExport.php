<?php

namespace App\Exports;

use App\Models\Borrow;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Database\Query\Builder;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ReportMonthExport implements FromQuery, WithHeadings, WithMapping, WithColumnFormatting, ShouldAutoSize, WithStyles
{
    /**
     * @return \Illuminate\Support\Collection
     */

    use Exportable;

    public function forMonth(string $month)
    {
        $this->month = $month;
        return $this;
    }

    public function query()
    {
        // TODO: Implement query() method.
        return Borrow::query()->whereMonth('created_at', $this->month)->orderBy('borrow_status', 'desc');
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

        if ($row) {
            foreach ($row->borrow_name as $item) {
                $name[] = json_decode('"' . $item . '"');
            }
        }

        $newName = join("\n", $name);
        $listId = join("\n", $row->borrow_list_id);
        $amount = join("\n", $row->borrow_amount);

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
            $row->borrow_user->user_prefix->prefix_name . " " . $row->borrow_user->firstname . " " . $row->borrow_user->lastname,
            $status,
            $row->description ? $row->description : "-",
            $row->created_at
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $styleArray = [
            'font' => [
                'name' => 'TH SarabunPSK',
                'size' => 18,
            ],
        ];
        $styleHeader = [
            'font' => [
//                'name' => 'TH SarabunPSK',
                'size' => 19,
                'bold' => true,
            ],
        ];
        $styleBold = [
            'font' => [
                'bold' => true
            ]
        ];
        $colorHeader = [
            'fillType' => 'solid','rotation' => 0, 'color' => ['rgb' => 'D9D9D9']
        ];

        $sheet->getStyle('A:C')->getAlignment()->setWrapText(true);
        $sheet->getStyle('A:C')->getAlignment()->setHorizontal('left');
        $sheet->getStyle('A:G')->getAlignment()->setVertical('center');
        $sheet->setAutoFilter('B1:G1');
        $sheet->getStyle('A:G')->applyFromArray($styleArray);
        $sheet->getStyle('A1:G1')->applyFromArray($styleHeader);
        $sheet->getStyle('A1:G1')->getFill()->applyFromArray($colorHeader);
        $sheet->getStyle('A')->applyFromArray($styleBold);
//        return [
//            // Style the first row as bold text.
//            1    => ['font' => ['size' => 14]],
//        ];
    }

    public function columnFormats(): array
    {
        // TODO: Implement columnFormats() method.
        return [
            'G' => NumberFormat::FORMAT_DATE_DDMMYYYY,
        ];
    }
}
