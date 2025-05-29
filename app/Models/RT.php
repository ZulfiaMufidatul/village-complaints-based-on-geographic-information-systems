<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RT extends Model
{
    use HasFactory;
    protected $table = 'rts';
    protected $fillable = [
        'hamlet_id',
        'rw_id',
        'name',
    ];

    public function hamlet()
    {
        return $this->belongsTo(Hamlet::class);
    }
    
    public function rw()
    {
        return $this->belongsTo(RW::class);
    }
}
