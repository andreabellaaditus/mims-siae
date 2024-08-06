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
        Schema::create('siae_product_holders', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('siae_order_item_id')->index('siae_order_item_id')->nullable();
            $table->unsignedInteger('product_id')->index('product_id');
            $table->string('first_name',100);
            $table->string('last_name', 100);
            $table->timestamp('expired_at')->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siae_product_holders');
    }
};
