<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegionType extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_type',
        'region_type_full',
    ];
    public $timestamps = false;
}
