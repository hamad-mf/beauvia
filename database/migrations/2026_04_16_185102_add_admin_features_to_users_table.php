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
        // Modify role enum to include 'admin'
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('customer', 'shop_owner', 'freelancer', 'admin') NOT NULL DEFAULT 'customer'");
        
        Schema::table('users', function (Blueprint $table) {
            // Add suspension fields
            $table->boolean('is_suspended')->default(false)->after('role');
            $table->timestamp('suspended_at')->nullable()->after('is_suspended');
            
            // Add soft deletes
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['is_suspended', 'suspended_at', 'deleted_at']);
        });
    }
};
