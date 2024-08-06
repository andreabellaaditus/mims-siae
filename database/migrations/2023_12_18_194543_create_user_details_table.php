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
        Schema::create('user_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('business_name',255);
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
            $table->string('unique_code',255)->nullable();
            $table->string('cig',255)->nullable();
            $table->boolean('is_subcontractor')->default(false);
            $table->foreignId('contractor_id')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_details');
    }
};
