<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Disposable extends Model
{
    use HasFactory;

    protected $fillable = [
        'disposable_name',
        'disposable_amount',
        'disposable_status',
        'image',
        'amount_minimum',
        'type_id',
        'disposable_num',
    ];

    public function disposable_type()
    {
        return $this->belongsTo('App\Models\Type', 'type_id', 'id');
    }
}