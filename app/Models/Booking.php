<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'booking_code', 'user_id', 'bookable_type', 'bookable_id', 'staff_member_id',
        'booking_date', 'start_time', 'end_time', 'total_price', 'status',
        'notes', 'customer_address', 'customer_phone', 'cancellation_reason',
    ];

    protected $casts = [
        'booking_date' => 'date',
        'total_price' => 'decimal:2',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($booking) {
            if (!$booking->booking_code) {
                $booking->booking_code = 'BV-' . strtoupper(Str::random(8));
            }
        });
    }

    public function user() { return $this->belongsTo(User::class); }
    public function bookable() { return $this->morphTo(); }
    public function staffMember() { return $this->belongsTo(StaffMember::class); }
    public function services() { return $this->belongsToMany(Service::class, 'booking_services')->withPivot('price'); }
    public function review() { return $this->hasOne(Review::class); }

    public function scopePending($query) { return $query->where('status', 'pending'); }
    public function scopeConfirmed($query) { return $query->where('status', 'confirmed'); }
    public function scopeCompleted($query) { return $query->where('status', 'completed'); }
    public function scopeUpcoming($query) { return $query->where('booking_date', '>=', now()->toDateString()); }

    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-500/20 text-yellow-400',
            'confirmed' => 'bg-blue-500/20 text-blue-400',
            'in_progress' => 'bg-purple-500/20 text-purple-400',
            'completed' => 'bg-green-500/20 text-green-400',
            'cancelled' => 'bg-red-500/20 text-red-400',
            'no_show' => 'bg-gray-500/20 text-gray-400',
            default => 'bg-gray-500/20 text-gray-400',
        };
    }

    public function getProviderNameAttribute(): string
    {
        if ($this->bookable_type === Shop::class) {
            return $this->bookable->name ?? 'Unknown Shop';
        }
        return $this->bookable->user->name ?? 'Unknown Freelancer';
    }
}
