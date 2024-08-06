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
        Schema::create('user_personal_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('contract_qualification_id')->nullable()->constrained()->nullOnDelete();
            $table->timestamp('date_of_birth')->nullable();
            $table->integer('mobile_number')->nullable();
            $table->text('tax_code')->nullable();
            $table->text('city')->nullable();
            $table->text('address')->nullable();
            $table->integer('post_code')->nullable();
            $table->text('city_alt')->nullable();
            $table->text('address_alt')->nullable();
            $table->integer('post_code_alt')->nullable();
            $table->text('size')->nullable();
            $table->text('classification_level')->nullable();
            $table->timestamp('engagement_date')->nullable();
            $table->timestamp('termination_date')->nullable();
            $table->text('subsidiary_id')->nullable();
            $table->text('geobadge_id')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_personaldatas');
    }
};
