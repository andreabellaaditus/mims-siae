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
        Schema::table('scans', function (Blueprint $table) {
            $table->string('scan_area', 255)->nullable();
        });
        Schema::table('siae_scans', function (Blueprint $table) {
            $table->string('scan_area', 255)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scans');
        Schema::dropIfExists('scan_area');
    }
};
