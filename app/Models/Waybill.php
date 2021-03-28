<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Allocation;

class Waybill extends Model
{
    use HasFactory;

    protected $fillable = [
        'allocation_id',
        'dispatched_at',
        'dquantity',
        'dbags',
        'received_at',
        'rquantity',
        'rbags',
        'driver',
        'dphone',
        'truck',
        'dispatcher',
        'receiver',
    ];

    public function allocation()
    {
        return $this->belongsTo(Allocation::class);
    }

}
