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
        Schema::table('cumulative_scans', function (Blueprint $table) {
            $table->index('qr_code');
            $table->index('site_id');
            $table->index('created_at');
            $table->index(['qr_code', 'created_at']);
        });

        Schema::table('product_cumulatives', function (Blueprint $table) {
            $table->index(['product_id', 'site_id']);
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cumulative_scans', function (Blueprint $table) {
            $table->dropIndex(['qr_code']);
            $table->dropIndex(['site_id']);
            $table->dropIndex('created_at');
            $table->dropIndex(['qr_code', 'created_at']);
        });

        Schema::table('product_cumulatives', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'site_id']);
        });
    }
};
