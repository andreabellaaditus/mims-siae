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
        Schema::table('orders', function (Blueprint $table) {
            $table->index('created_at');
        });

        Schema::table('cashiers', function (Blueprint $table) {
            $table->index(['id', 'site_id']);
        });

        Schema::table('cashiers', function (Blueprint $table) {
            $table->index('name');
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
        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex('orders_created_at_index');
            $table->dropIndex('orders_cashier_id_index');
        });

        Schema::table('cashiers', function (Blueprint $table) {
            $table->dropIndex('cashiers_id_site_id_index');
            $table->dropIndex('cashiers_name_index');
        });
    }
};
