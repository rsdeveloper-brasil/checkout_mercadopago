<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class FeatureSku extends Pivot
{
    use HasFactory, softDeletes;

    protected $fillable = [
        'sku_id',
        'feature_id',
        'value',
    ];
}
