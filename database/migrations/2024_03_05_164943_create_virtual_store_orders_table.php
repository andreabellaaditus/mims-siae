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
        Schema::create('virtual_store_orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->string('status', 50);
            $table->string('description');
            $table->boolean('email')->default(false);
            $table->string('order_file')->nullable();
            $table->boolean('can_delete')->default(true);
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
        Schema::dropIfExists('virtual_store_orders');
    }
};
