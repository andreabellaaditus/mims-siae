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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')->index('user_id');
            $table->string('name');
            $table->string('vat_number', 50);
            $table->string('fiscal_code', 50);
            $table->string('unique_code', 50);
            $table->string('phone_number', 50);
            $table->string('iban', 50)->nullable();
            $table->string('address');
            $table->string('city', 50);
            $table->string('post_code', 10);
            $table->unsignedInteger('country_id')->index('country_id');
            $table->boolean('status')->default(true);
            $table->string('sending_oda', 20)->nullable()->default('manual');
            $table->boolean('is_subcontractor')->nullable()->default(false);
            $table->unsignedInteger('contractor_id')->nullable();
            $table->string('supplier_code', 50)->nullable();
            $table->string('account_code', 50)->nullable();
            $table->string('vat_description', 50)->nullable();
            $table->string('referent', 100)->nullable();
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
        Schema::dropIfExists('suppliers');
    }
};
