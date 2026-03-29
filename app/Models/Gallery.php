<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ['imageable_type', 'imageable_id', 'image_path', 'caption', 'sort_order'];

    public function imageable() { return $this->morphTo(); }

    public function getImageUrlAttribute(): string
    {
        return asset('storage/' . $this->image_path);
    }
}
