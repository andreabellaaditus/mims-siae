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
        Schema::create('virtual_store_lots', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->string('name', 50);
            $table->unsignedInteger('user_id')->index('user_id');
            $table->unsignedInteger('company_id')->index('company_id');
            $table->unsignedInteger('status_id')->index('status_id');
            $table->unsignedInteger('qty');
            $table->unsignedInteger('virtual_store_order_id')->nullable()->index('order_id');
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
        Schema::dropIfExists('virtual_store_lots');
    }
};
