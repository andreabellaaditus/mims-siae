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
        Schema::table('access_control_changes', function (Blueprint $table) {
            $table->foreign(['access_control_device_id'], 'access_control_changes_ibfk_1')->references(['id'])->on('access_control_devices')->onUpdate('NO ACTION')->onDelete('NO ACTION');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('access_control_changes', function (Blueprint $table) {
            $table->dropForeign('access_control_changes_ibfk_1');
        });
    }
};
