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

        Schema::create('safes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('site_id');
            $table->string('name', 255);
            $table->timestamps();
        });
    }
       /* Io ho queste 2 tabelle, rappresenta alcune casseforti che contengono dei soldi. Il campo amount può essere sia positivo che negativo, perchè si può sia prelevare che versare.
        La query*/
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('safes');
    }
};
