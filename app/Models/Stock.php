<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_num',
        'stock_name',
        'stock_amount',
        'stock_status',
        'image',
        'type_id',
        'defective_stock'
    ];

    public function stock_type()
    {
        return $this->belongsTo('App\Models\Type', 'type_id', 'id');
    }

}