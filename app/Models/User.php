<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name', 'email', 'password', 'role', 'phone', 'avatar', 'address', 'city', 'latitude', 'longitude',
        'is_suspended', 'suspended_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    public function isCustomer(): bool { return $this->role === 'customer'; }
    public function isShopOwner(): bool { return $this->role === 'shop_owner'; }
    public function isFreelancer(): bool { return $this->role === 'freelancer'; }
    public function isAdmin(): bool { return $this->role === 'admin'; }

    public function shop() { return $this->hasOne(Shop::class); }
    public function freelancerProfile() { return $this->hasOne(FreelancerProfile::class); }
    public function bookings() { return $this->hasMany(Booking::class); }
    public function reviews() { return $this->hasMany(Review::class); }
    public function favorites() { return $this->hasMany(Favorite::class); }
    public function adminActivityLogs() { return $this->hasMany(AdminActivityLog::class, 'admin_id'); }

    // Query scopes
    public function scopeAdmins($query) { return $query->where('role', 'admin'); }
    public function scopeSuspended($query) { return $query->where('is_suspended', true); }
    public function scopeActive($query) { return $query->where('is_suspended', false); }

    public function getAvatarUrlAttribute(): string
    {
        if ($this->avatar) {
            return asset('storage/' . $this->avatar);
        }
        return 'https://ui-avatars.com/api/?name=' . urlencode($this->name) . '&background=7C3AED&color=fff&size=128';
    }
}
