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
        Schema::create('access_control_device_debug', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('access_control_device_id');
            $table->string('status', 45)->nullable();
            $table->string('message')->nullable();
            $table->text('request')->nullable();
            $table->text('response')->nullable();
            $table->string('qr_code')->nullable();
            $table->string('qr_code_type', 45)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_control_device_debug');
    }
};
