<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffMember extends Model
{
    use HasFactory;

    protected $fillable = ['shop_id', 'name', 'title', 'avatar', 'bio', 'is_active', 'sort_order'];

    protected $casts = ['is_active' => 'boolean'];

    public function shop() { return $this->belongsTo(Shop::class); }
    public function bookings() { return $this->hasMany(Booking::class); }

    public function getAvatarUrlAttribute(): string
    {
        return $this->avatar
            ? asset('storage/' . $this->avatar)
            : 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=7C3AED&color=fff&size=128';
    }
}
