<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Street extends Model
{
    use HasFactory;
    protected $fillable = [
        'street_name',
        'street_type_id',
        'city_id',
        'settlement_id',
        'region_id'
    ];
    public $timestamps = false;
}
