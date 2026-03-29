<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'icon', 'description', 'image', 'sort_order', 'is_active'];

    public function shops() { return $this->hasMany(Shop::class); }
    public function freelancerProfiles() { return $this->hasMany(FreelancerProfile::class); }

    public function scopeActive($query) { return $query->where('is_active', true); }
    public function scopeOrdered($query) { return $query->orderBy('sort_order'); }
}
