<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
//    public $timestamps = false;

    protected $fillable = [
        'borrow_name',
        'borrow_status',
        'user_id',
    ];

    public function borrow_user()
    {
        return $this->belongsTo('App\Models\User', 'user_id', 'id');
    }
}
