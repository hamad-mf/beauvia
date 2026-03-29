<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('time_slots', function (Blueprint $table) {
            $table->id();
            $table->string('slotable_type');
            $table->unsignedBigInteger('slotable_id');
            $table->tinyInteger('day_of_week'); // 0=Sunday, 6=Saturday
            $table->time('open_time');
            $table->time('close_time');
            $table->boolean('is_available')->default(true);
            $table->timestamps();

            $table->index(['slotable_type', 'slotable_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('time_slots');
    }
};
