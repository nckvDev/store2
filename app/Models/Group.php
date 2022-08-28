<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = [
        'group_name',
        // 'department_id',
        'department_name',
      ];
      
    //   public function group_department()
    //   {
    //       return $this->belongsTo('App\Models\Department','department_id',  'id');
    //   }
}