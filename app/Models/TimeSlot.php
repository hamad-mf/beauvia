<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = ['slotable_type', 'slotable_id', 'day_of_week', 'open_time', 'close_time', 'is_available'];

    protected $casts = ['is_available' => 'boolean'];

    public function slotable() { return $this->morphTo(); }

    public function getDayNameAttribute(): string
    {
        $days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
        return $days[$this->day_of_week] ?? '';
    }
}
