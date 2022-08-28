<?php

namespace App\Imports;

use App\Models\Disposable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class DisposableImport implements ToModel,WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Disposable([
            'disposable_name' => $row['disposable_name'],
            'disposable_amount' => $row['disposable_amount'],
            'disposable_status' => $row['disposable_status'],
            'image' => $row['image'],
            'amount_minimum' => $row['amount_minimum'],
            'type_id' => $row['type_id'],
            'disposable_num' => $row['disposable_num'],
        ]);
    }
}