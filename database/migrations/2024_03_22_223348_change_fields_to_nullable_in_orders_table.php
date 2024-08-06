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
        // Modifica il tipo delle colonne
        Schema::table('orders', function (Blueprint $table) {
            $table->unsignedBigInteger('cashier_id')->nullable()->change();
            $table->unsignedBigInteger('company_id')->nullable()->change();
            $table->double('duty_stamp', 8, 2)->nullable()->change();
        });
    }

};
