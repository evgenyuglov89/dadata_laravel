<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StreetType extends Model
{
    use HasFactory;
    protected $fillable = [
        'street_type',
        'street_type_full',
    ];
    public $timestamps = false;
}
