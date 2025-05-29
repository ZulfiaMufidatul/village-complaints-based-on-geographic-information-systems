<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RW extends Model
{
    use HasFactory;
    protected $table = 'rws';
    protected $fillable = [
        'hamlet_id',
        'name',
    ];

    public function hamlet()
    {
        return $this->belongsTo(Hamlet::class);
    }

    public function rt()
    {
        return $this->hasMany(RT::class);
    }
}
