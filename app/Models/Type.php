<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    use HasFactory;

    protected $fillable = [
        'type_detail'
    ];

    protected $primaryKey = 'id';

    public function type_stock()
    {
        return $this->hasMany('App\Models\Stock', 'type_id', 'id');
    }

    public function type_device()
    {
        return $this->hasMany('App\Models\Device', 'type_id', 'id');
    }
}
