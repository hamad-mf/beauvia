<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'booking_id', 'reviewable_type', 'reviewable_id', 'rating', 'comment', 'is_verified', 'is_flagged'];

    protected $casts = [
        'is_verified' => 'boolean',
        'is_flagged' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function booking() { return $this->belongsTo(Booking::class); }
    public function reviewable() { return $this->morphTo(); }

    public function scopeFlagged($query) { return $query->where('is_flagged', true); }
}
