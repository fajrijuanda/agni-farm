<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // role: 'superadmin', 'admin'
            $table->string('role')->default('admin')->after('password');
            $table->unsignedBigInteger('region_id')->nullable()->after('role');

            // Add foreign key but no constraint yet to avoid issues during migration if regions table empty
            // $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
        });

        Schema::table('products', function (Blueprint $table) {
            $table->unsignedBigInteger('region_id')->nullable()->after('slug');
            // $table->foreign('region_id')->references('id')->on('regions')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['role', 'region_id']);
        });

        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('region_id');
        });
    }
};
