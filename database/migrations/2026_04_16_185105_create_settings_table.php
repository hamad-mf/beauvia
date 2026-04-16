<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->text('value');
            $table->timestamps();
        });

        // Insert default settings
        DB::table('settings')->insert([
            ['key' => 'commission_rate', 'value' => '10', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'allow_new_providers', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'allow_bookings', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'cancellation_hours', 'value' => '24', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'min_booking_advance_hours', 'value' => '2', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'max_booking_advance_days', 'value' => '90', 'created_at' => now(), 'updated_at' => now()],
            ['key' => 'email_notifications_enabled', 'value' => '1', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
