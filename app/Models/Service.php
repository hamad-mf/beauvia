<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'serviceable_type', 'serviceable_id', 'category_id', 'name',
        'description', 'price', 'duration_minutes', 'is_active', 'sort_order',
    ];

    protected $casts = ['price' => 'decimal:2', 'is_active' => 'boolean'];

    public function serviceable() { return $this->morphTo(); }
    public function category() { return $this->belongsTo(Category::class); }
    public function bookingServices() { return $this->hasMany(BookingService::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }

    public function getFormattedDurationAttribute(): string
    {
        $hours = intdiv($this->duration_minutes, 60);
        $mins = $this->duration_minutes % 60;
        if ($hours > 0 && $mins > 0) return "{$hours}h {$mins}min";
        if ($hours > 0) return "{$hours}h";
        return "{$mins}min";
    }
}
