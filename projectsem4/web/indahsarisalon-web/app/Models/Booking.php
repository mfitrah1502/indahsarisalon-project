<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'stylist_id', 'treatment_id', 
        'reservation_datetime', 'total_price', 
        'status', 'payment_status'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function stylist()
    {
        return $this->belongsTo(User::class, 'stylist_id');
    }

    public function treatment()
    {
        return $this->belongsTo(Treatment::class);
    }

    public function details()
    {
        return $this->hasMany(BookingDetail::class);
    }
}
