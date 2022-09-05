<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
//    public $timestamps = false;

    protected $fillable = [
        'borrow_list_id',
        'borrow_name',
        'borrow_status',
        'borrow_amount',
        'user_id',
    ];

    protected $casts = [
        'borrow_list_id' => 'array',
        'borrow_name' => 'array',
        'borrow_amount' => 'array'
    ];

    public function borrow_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
