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


        Schema::table('siae_orders', function (Blueprint $table) {
            $table->index('progressive');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Rimuovi gli indici se necessario (nel caso di rollback delle migrazioni)
        Schema::table('siae_orders', function (Blueprint $table) {
            $table->dropIndex('progressive');
        });

    }
};
