<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'branchs_id',
        'stocks_code',
        'barcode',
        'stocks_name',
        'remaining_amount',
        'unit',
        'purchase_price',
        'sale_price',
    ];
}
