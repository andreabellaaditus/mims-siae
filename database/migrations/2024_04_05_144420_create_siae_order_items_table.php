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
        Schema::create('siae_order_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('siae_order_id')->index('siae_order_id');
            $table->unsignedInteger('product_id')->index('product_id');
            $table->unsignedInteger('promo_id')->nullable();
            $table->unsignedInteger('order_item_status_id')->index('order_item_status');
            $table->boolean('order_item_delete_flag')->nullable()->default(false);
            $table->integer('qty')->index('qty');
            $table->double('price', 8, 2)->index('price');
            $table->dateTime('validity');
            $table->boolean('is_cumulative')->default(false);
            $table->string('printable_qr_code', 100)->index('printable_qr_code');
            $table->string('printable_qr_link')->nullable();
            $table->date('date_service')->nullable()->index('date_service');
            $table->time('hour_service')->nullable()->index('hour_service');
            $table->string('language_service')->nullable();
            $table->integer('num_pax_service')->nullable();
            $table->string('pickup_service')->nullable();
            $table->integer('duration_service')->nullable();
            $table->unsignedInteger('reduction_id')->nullable()->index('reduction_id');
            $table->text('reduction_notes')->nullable();
            $table->string('notes')->nullable();
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
            $table->double('discount', 5, 2)->nullable()->default(0);
            $table->integer('payment_id')->nullable();
            $table->double('credit_card_fees', 8, 2)->nullable();
            $table->integer('scans_counter')->nullable()->default(0);;
            $table->boolean('delivered')->nullable()->default(false);
            $table->timestamp('delivered_at')->nullable();
            $table->double('transfer_amount', 8, 2)->nullable();
            $table->timestamp('transferred_at')->nullable();
            $table->string('transferred_to')->nullable();
            $table->string('transfer_id')->nullable();
            $table->text('transfer_error')->nullable();
            $table->integer('payment_transfer_id')->nullable();
            $table->unsignedInteger('product_place_order_id')->nullable()->index('product_place_order_id');
            $table->unsignedInteger('supplier_id')->nullable()->index('supplier_id');
            $table->integer('to_be_delete')->nullable()->default(0);
            $table->dateTime('deleted_at')->nullable();
            $table->string('supplier_percentage', 10)->nullable();
            $table->string('additional_code', 5)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('siae_order_items');
    }
};
