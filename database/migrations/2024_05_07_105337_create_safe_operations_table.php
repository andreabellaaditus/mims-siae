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
        Schema::create('safe_operations', function (Blueprint $table) {
            $table->increments('id');
            $table->double('amount', 8, 2);
            $table->integer('user_id');
            $table->integer('safe_id');
            $table->string('first_name', 255);
            $table->string('last_name', 255);
            $table->string('company', 255);
            $table->timestamp('operation_date');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
            $table->index('safe_id');
        });


    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('safe_operations');
    }
};
