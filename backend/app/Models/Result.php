<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'results' => 'array'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getBestScore()
    {

    }
}
