<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class NIK extends Model
{
    use HasFactory;

    protected $table = "nik";

    protected $fillable = [
        'value',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'nik_id');
    }
}
