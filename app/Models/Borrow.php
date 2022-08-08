<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrow extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'borrow_id',
        'borrow_name',
        'borrow_user_id',
        'borrow_user_fname',
        'borrow_user_lname',
        'image',
    ];

}