<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hamlet extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function rws()
    {
        return $this->hasMany(RW::class);
    }

    public function rts()
    {
        return $this->hasMany(RT::class);
    }
}
