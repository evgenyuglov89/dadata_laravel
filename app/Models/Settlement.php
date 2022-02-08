<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settlement extends Model
{
    use HasFactory;
    protected $fillable = [
        'settlement_name',
        'settlement_type_id',
        'city_id',
        'region_id',
        'area_id'
    ];
    public $timestamps = false;
}
