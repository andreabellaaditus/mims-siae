<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('siae_scans', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('virtual_store_matrix_id')->nullable()->index('virtual_store_matrix_id');
            $table->unsignedInteger('operator_id')->nullable()->index('operator_id');
            $table->unsignedInteger('siae_order_item_id')->nullable()->index('order_item_id');
            $table->boolean('is_scanned')->default(false);
            $table->boolean('verification_needed')->default(false);
            $table->string('qr_code', 100)->index('qr_code');
            $table->dateTime('date_scanned');
            $table->dateTime('date_expiration')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siae_scans');
    }
};
