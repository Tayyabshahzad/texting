<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'plan_name',
        'min_smses',
        'max_smses',
        'monthly_price',
        'annual_price',
    ];
}
