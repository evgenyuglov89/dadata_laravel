<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_name',
        'area_type',
        'area_type_full',
        'area_type_id',
        'region_id'
    ];
    public $timestamps = false;
}
