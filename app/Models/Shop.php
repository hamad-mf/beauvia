<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'category_id', 'name', 'slug', 'description', 'address', 'city',
        'latitude', 'longitude', 'phone', 'email', 'website', 'logo', 'cover_image',
        'opening_hours', 'rating_avg', 'rating_count', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'opening_hours' => 'array',
        'rating_avg' => 'decimal:2',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function user() { return $this->belongsTo(User::class); }
    public function category() { return $this->belongsTo(Category::class); }
    public function services() { return $this->morphMany(Service::class, 'serviceable'); }
    public function staffMembers() { return $this->hasMany(StaffMember::class); }
    public function bookings() { return $this->morphMany(Booking::class, 'bookable'); }
    public function reviews() { return $this->morphMany(Review::class, 'reviewable'); }
    public function galleries() { return $this->morphMany(Gallery::class, 'imageable'); }
    public function timeSlots() { return $this->morphMany(TimeSlot::class, 'slotable'); }
    public function favorites() { return $this->morphMany(Favorite::class, 'favorable'); }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeFeatured($query) { return $query->where('is_featured', true); }

    public function getLogoUrlAttribute(): string
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('images/default-shop.png');
    }

    public function getCoverUrlAttribute(): string
    {
        return $this->cover_image ? asset('storage/' . $this->cover_image) : asset('images/default-cover.jpg');
    }

    public function updateRating(): void
    {
        $this->rating_avg = $this->reviews()->avg('rating') ?? 0;
        $this->rating_count = $this->reviews()->count();
        $this->save();
    }
}
