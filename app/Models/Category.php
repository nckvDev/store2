<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $table = 'categorys';

    protected $fillable = [
        'category_detail'
    ];

    public function category_type()
    {
        return $this->hasMany('App\Models\Type', 'category_id', 'id');
    }

}
