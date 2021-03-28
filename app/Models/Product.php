<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Allocation;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function allocations()
    {
        return $this->hasMany(Allocation::class);
    }
}
