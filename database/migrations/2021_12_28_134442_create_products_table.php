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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('service_id')->index('products_service_id_foreign');
            $table->boolean('has_supplier')->default(false);
            $table->unsignedBigInteger('supplier_id')->nullable()->index('products_supplier_id_foreign');
            $table->unsignedBigInteger('product_subcategory_id')->nullable()->index('products_product_subcategory_id_foreign');
            $table->boolean('active')->default(true);
            $table->string('code', 100);
            $table->string('article', 100);
            $table->string('name', 100);
            $table->string('slug', 100);
            $table->double('price_sale', 8, 3);
            $table->double('price_purchase', 8, 3);
            $table->double('price_web', 8, 3);
            $table->double('vat', 8, 3)->default(0);
            $table->boolean('price_per_pax')->default(true);
            $table->integer('num_pax')->default(1);
            $table->boolean('check_document')->default(false);
            $table->boolean('printable')->default(false);
            $table->boolean('deliverable')->default(false);
            $table->boolean('billable')->default(false);
            $table->boolean('is_date')->default(false);
            $table->boolean('is_hour')->default(false);
            $table->boolean('is_name')->default(false);
            $table->boolean('is_card')->default(false);
            $table->boolean('is_link')->default(false);
            $table->integer('is_cumulative')->nullable();
            $table->string('product_link')->nullable();
            $table->enum('matrix_generation_type', ['generated', 'on_request'])->nullable();
            $table->char('matrix_prefix', 4)->nullable();
            $table->enum('validity_from_issue_unit', ['days', 'weeks', 'months', 'years'])->nullable();
            $table->integer('validity_from_issue_value')->nullable();
            $table->enum('validity_from_burn_unit', ['days', 'weeks', 'months', 'years'])->nullable();
            $table->integer('validity_from_burn_value')->nullable();
            $table->integer('max_scans')->default(1);
            $table->boolean('has_additional_code')->default(false);
            $table->string('qr_code')->nullable();
            $table->integer('online_reservation_delay')->default(0);
            $table->text('notes')->nullable();
            $table->json('sale_matrix')->nullable();
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
        Schema::dropIfExists('products');
    }
};
