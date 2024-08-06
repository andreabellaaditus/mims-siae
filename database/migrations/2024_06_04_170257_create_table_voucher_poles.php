<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('voucher_poles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pole_id')->constrained('poles')->onDelete('cascade');
            $table->foreignId('travel_agency_id')->constrained('users')->onDelete('cascade');
            $table->double('remaining_credit');
            $table->double('old_remaining_credit');
            $table->timestamps();
        });
    }

    /**
     * Annulla le migrazioni per la tabella `voucher_poles`.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_poles');
    }
};
