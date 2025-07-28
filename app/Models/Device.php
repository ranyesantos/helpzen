<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'model',
        'brand',
        'device_code',
        'serial_number'
    ];

    public function getFullNameAttribute()
    {
        return "{$this->brand} {$this->model}";
    }
}
