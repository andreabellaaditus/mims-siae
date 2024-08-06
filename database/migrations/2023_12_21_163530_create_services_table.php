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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_category_id')->constrained()->onDelete('cascade');
            $table->foreignId('school_degree_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('site_id')->nullable()->constrained()->nullOnDelete();
            $table->string('code',100);
            $table->string('name',100);
            $table->string('slug',100);
            $table->boolean('active')->default(true);
            $table->boolean('is_purchasable')->default(false);
            $table->boolean('is_date')->default(false);
            $table->boolean('is_hour')->default(false);
            $table->boolean('is_language')->default(false);
            $table->boolean('is_pickup')->default(false);
            $table->boolean('is_min_pax')->default(false);
            $table->integer('min_pax')->nullable();
            $table->boolean('is_max_pax')->default(false);
            $table->integer('max_pax')->nullable();
            $table->boolean('is_duration')->default(false);
            $table->boolean('is_pending')->default(false);
            $table->integer('online_reservation_delay')->nullable();
            $table->integer('closing_reservation')->nullable();
            $table->boolean('is_archived')->default(false);
            $table->timestamp('archived_at')->nullable();
            $table->foreignId('archived_by')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};
