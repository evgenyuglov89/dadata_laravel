<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AreaType extends Model
{
    use HasFactory;
    protected $fillable = [
        'area_type',
        'area_type_full',
    ];
    public $timestamps = false;
}
