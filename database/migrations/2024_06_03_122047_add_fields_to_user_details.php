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
        Schema::table('user_details', function (Blueprint $table) {
            $table->unsignedBigInteger('commercial_referent_id')->nullable();
            $table->foreign('commercial_referent_id')->references('id')->on('users')->onDelete('set null');
            $table->enum('invoice_type', ['on_fly', 'daily', 'weekly', 'no_invoice'])->default('on_fly')->nullable();
            $table->enum('purchase_type', ['on_fly', 'free'])->default('on_fly')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_details', function (Blueprint $table) {
            $table->dropForeign(['commercial_referent_id']);
            $table->dropColumn('commercial_referent_id');
            $table->dropColumn('invoice_type');
            $table->dropColumn('purchase_type');
        });
    }

};
