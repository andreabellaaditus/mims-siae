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
        Schema::create('access_control_devices', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code')->unique('code');
            $table->string('area', 100)->nullable();
            $table->string('name', 45)->nullable();
            $table->string('type');
            $table->integer('site_id');
            $table->boolean('active');
            $table->string('status', 45)->nullable();
            $table->integer('logging_enabled')->nullable();
            $table->timestamps();
            $table->boolean('entrance_enabled')->default(false);
            $table->boolean('exit_enabled')->default(false);
            $table->string('last_message', 500)->nullable();
            $table->string('ip', 15)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('access_control_devices');
    }
};
