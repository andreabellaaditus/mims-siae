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
        Schema::create('access_control_pass', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->json('enabled_sites')->nullable();
            $table->string('qr_code', 32)->nullable();
            $table->string('first_name');
            $table->string('last_name');
            $table->date('expire_at');
            $table->unsignedInteger('issued_by');
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
        Schema::dropIfExists('access_control_pass');
    }
};
