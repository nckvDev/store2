<?php

namespace App\Imports;

use App\Models\Stock;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StockImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Stock([
            'stock_name' => $row['stock_name'],
            'stock_amount' => $row['stock_amount'],
            'stock_status' => $row['stock_status'],
            'image' => $row['image'],
            'type_id' => $row['type_id'],
            'stock_num' => $row['stock_num'],
            'defective_stock' => $row['defective_stock'],
        ]);
    }
}
