<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Command extends Model
{
    use HasFactory;

    protected $fillable = [
        'device_id', 'operation', 'description', 'command', 'result', 'format',
    ];

    protected $casts = [
        'format' => 'array',
    ];

    public function device()
    {
        return $this->belongsTo(Device::class);
    }
}
