<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'identifier', 'description', 'manufacturer', 'url',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function commands()
    {
        return $this->hasMany(Command::class);
    }
}
