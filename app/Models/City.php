<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $fillable = [
        'city_name',
        'city_type',
        'city_type_full',
        'region_id',
        'area_id'
    ];
    public $timestamps = false;
}
