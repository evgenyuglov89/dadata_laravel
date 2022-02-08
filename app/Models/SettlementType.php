<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SettlementType extends Model
{
    use HasFactory;
    protected $fillable = [
        'settlement_type',
        'settlement_type_full',
    ];
    public $timestamps = false;
}
