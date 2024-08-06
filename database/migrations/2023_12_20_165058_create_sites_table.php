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
        Schema::create('sites', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pole_id')->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->foreignId('concession_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('unlock_matrix_pole_id')->nullable()->constrained()->references('id')->on('poles')->nullOnDelete();
            $table->string('slug',100);
            $table->string('name',100);
            $table->string('canonical_name',255);
            $table->string('address',100)->nullable();
            $table->string('city',100)->nullable();
            $table->string('region',50)->nullable();
            $table->decimal('lat', 11, 7)->default(0);
            $table->decimal('lng', 11, 7)->default(0);
            $table->boolean('is_comingsoon')->default(false);
            $table->boolean('is_closed')->default(false);
            $table->boolean('in_concession')->default(true);
            $table->string('matrix_suffix',2)->nullable();
            $table->boolean('access_control_enabled')->default(false);
            $table->boolean('poll_enabled')->default(false);
            $table->boolean('cashier_fee_enabled')->default(false);
            $table->boolean('tvm')->default(false);
            $table->boolean('onsite_auto_scan')->default(false);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->default(DB::raw('CURRENT_TIMESTAMP on update CURRENT_TIMESTAMP'));

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sites');
    }
};
