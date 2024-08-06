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
        Schema::create('order_item_reductions', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('order_item_id')->index('order_item_id');
            $table->unsignedInteger('reduction_id')->index('reduction_id');
            $table->unsignedInteger('reduction_field_id')->index('reduction_field_id');
            $table->string('value', 255)->nullable();

            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_reductions');
    }
};
