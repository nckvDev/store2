<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Conform extends Model
{
    use HasFactory;
    protected $table = 'conform';
    protected $fillable = [
        'user_id',
        'firstname',
        'lastname',
        'status',
      ];
}