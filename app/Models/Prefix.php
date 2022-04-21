<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prefix extends Model
{
    use HasFactory;

    protected $fillable = [
        'prefix_name'
    ];

    public function prefix_user()
    {
        return $this->hasMany('App\Models\User', 'prefix_id', 'id');
    }
}
