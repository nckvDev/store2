<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
      'device_num',
      'device_name',
      'device_status',
      'type_id',
      'location',
      'image',
      'device_year',
      'defective_device'
    ];

    public function device_type() {
        return $this->belongsTo('App\Models\Type', 'type_id', 'id');
    }
}
