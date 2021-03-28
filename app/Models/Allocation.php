<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Product;
use App\Models\Waybill;
use App\Models\Plant;
use App\Models\Point;

class Allocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'allocated_at',
        'product_id',
        'quantity',
        'point_id',
        'plant_id',
    ];

    public function plant()
    {
        return $this->belongsTo(Plant::class);
    }

    public function point()
    {
        return $this->belongsTo(Point::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function waybills()
    {
        return $this->hasMany(Waybill::class);
    }
}
