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
        Schema::create('user_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamp('course_date')->nullable();
            $table->text('course_description')->nullable();
            $table->integer('course_duration')->nullable();
            $table->integer('course_validity')->nullable();
            $table->timestamp('course_expiry')->nullable();
            $table->text('course_effectiveness_description')->nullable();
            $table->string('course_effectiveness_evaulation',100)->nullable();
            $table->timestamp('course_effectiveness_date')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_courses');
    }
};
