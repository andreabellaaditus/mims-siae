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
        Schema::create('siae_scan_logs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('qr_code');
            $table->string('type', 50)->nullable();
            $table->integer('site_id')->nullable();
            $table->string('status')->nullable();
            $table->text('response')->nullable();
            $table->timestamps();
            $table->integer('product_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siae_scan_logs');
    }
};
