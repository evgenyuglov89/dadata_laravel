<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Region extends Model
{
    use HasFactory;
    protected $fillable = [
        'region_name',
        'region_type_id',
    ];
    public $timestamps = false;
}
