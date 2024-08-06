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
        Schema::create('site_hours', function (Blueprint $table) {
            $table->increments('id');
            $table->foreignId('site_id')->constrained()->onDelete('cascade');
            $table->char('day', 5);
            $table->time('opening');
            $table->time('break_start')->nullable();
            $table->time('break_end')->nullable();
            $table->time('closing');
            $table->time('closing_ticket_office');
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
        Schema::dropIfExists('site_hours');
    }
};
