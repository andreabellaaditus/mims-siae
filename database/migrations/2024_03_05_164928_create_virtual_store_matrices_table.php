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
        Schema::create('virtual_store_matrices', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('lot_id')->nullable()->index('lot_id');
            $table->string('code', 10);
            $table->tinyInteger('year');
            $table->string('progressive', 10);
            $table->string('status', 50)->index('status');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent();
            $table->integer('purchase_group')->nullable()->index('purchase_group');
            $table->timestamp('purchased_at')->nullable();

            $table->index(['status', 'product_id', 'purchase_group'], 'search');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('virtual_store_matrices');
    }
};
