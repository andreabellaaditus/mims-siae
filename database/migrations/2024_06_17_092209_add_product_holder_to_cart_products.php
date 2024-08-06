<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('cart_products', function (Blueprint $table) {
            $table->string('holder_first_name', 255)->nullable();
            $table->string('holder_last_name', 255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cart_products', function (Blueprint $table) {
            $table->dropColumn('holder_first_name');
            $table->dropColumn('holder_last_name');
        });
    }
};
