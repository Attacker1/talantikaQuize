<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quize extends Model
{
    use HasFactory;

    protected $fillabe = [
        'status',
        'ending'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
