<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Complaint extends Model
{
    use HasFactory;

    protected $fillable = [
        'hamlet',
        'rw',
        'rt',
        'infrastructure_category',
        'complaints_code',
        'name',
        'phone',
        'email',
        'description',
        'photo',
        'longitude',
        'latitude',
        'date_time',
        'process_comment',
        'response',
        'request_status',
        'status_complaint',
    ];

    // validasi di backend menghindari manipulasi data untuk status dinamis
    protected static function booted()
    {
        static::saving(function ($complaint) {
            if ($complaint->request_status === 'rejected') {
                $complaint->status_complaint = 'cancel';
            }

            if ($complaint->request_status === 'approved') {
                // Jika status sebelumnya "cancel", dan status permintaan sekarang "approved",
                // pastikan status_complaint bukan "cancel"
                if ($complaint->status_complaint === 'cancel') {
                    $complaint->status_complaint = 'pending'; // Atur default ke pending
                }
            }
        });
    }
}
