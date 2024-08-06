<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('slug',100);
            $table->string('name',100);
            $table->string('address',100)->nullable();
            $table->string('post_code',100)->nullable();
            $table->string('city',100)->nullable();
            $table->string('county',100)->nullable();
            $table->foreignId('country_id')->nullable()->constrained()->nullOnDelete();
            $table->string('phone',100)->nullable();
            $table->string('vat',100)->nullable();
            $table->string('tax_code',100)->nullable();
            $table->string('iban',100)->nullable();
            $table->string('certified_email',255)->nullable();
            $table->string('unique_code',100)->nullable();
            $table->string('idTransmitter',100)->nullable();
            $table->string('idTransferorLender',100)->nullable();
            $table->string('taxRegime',4)->nullable();
            $table->string('reaOffice',2)->nullable();
            $table->string('reaNum',50)->nullable();
            $table->string('reaStatus',2)->nullable();
            $table->string('logo',255)->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
