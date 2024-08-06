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
        Schema::create('cashier_register_closures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->references('id')->on('users')->nullOnDelete();
            $table->foreignId('cashier_id')->constrained()->onDelete('cascade');
            $table->string('cashier_detail', 45)->nullable();
            $table->date('date');
            $table->double('opening_cash_amount_last_closure', 8, 2);
            $table->double('opening_cash_amount_registered', 8, 2);
            $table->tinyInteger('opening_stock_check_passed')->nullable();
            $table->string('opening_stock_check_values', 500)->nullable();
            $table->time('opened_at');
            $table->text('opening_notes')->nullable();
            $table->double('closure_cash_amount_calculated', 8, 2)->nullable();
            $table->double('closure_paid_amount_calculated', 8, 2)->nullable();
            $table->double('closure_pos_amount_calculated', 8, 2)->nullable();
            $table->double('closure_voucher_amount_calculated', 8, 2)->nullable();
            $table->double('closure_cash_amount_registered', 8, 2)->nullable();
            $table->double('closure_paid_amount_registered', 8, 2)->nullable();
            $table->double('closure_pos_amount_registered', 8, 2)->nullable();
            $table->double('closure_voucher_amount_registered', 8, 2)->nullable();
            $table->double('closure_hand_amount_registered', 8, 2)->nullable();
            $table->string('closure_paid_amount_receipt', 500)->nullable();
            $table->string('closure_pos_amount_receipt', 500)->nullable();
            $table->string('closure_hand_amount_receipt', 500)->nullable();
            $table->unsignedBigInteger('closure_hand_amount_to')->nullable();
            $table->time('closed_at')->nullable();
            $table->text('closure_notes')->nullable();
            $table->tinyInteger('verified')->nullable();
            $table->datetime('verified_at')->nullable();
            $table->unsignedBigInteger('verified_by')->nullable();
            $table->double('closure_cash_amount_accounted', 8, 2)->nullable();
            $table->double('closure_paid_amount_accounted', 8, 2)->nullable();
            $table->double('closure_pos_amount_accounted', 8, 2)->nullable();
            $table->double('closure_voucher_amount_accounted', 8, 2)->nullable();
            $table->double('closure_hand_amount_accounted', 8, 2)->nullable();
            $table->double('closure_stripe_amount_calculated', 8, 2)->nullable();
            $table->double('closure_stripe_amount_accounted', 8, 2)->nullable();
            $table->double('closure_bank_amount_calculated', 8, 2)->nullable();
            $table->double('closure_bank_amount_accounted', 8, 2)->nullable();
            $table->timestamps();
            $table->tinyInteger('closure_stock_check_passed')->nullable();
            $table->string('closure_stock_check_values', 500)->nullable();
            $table->unsignedBigInteger('cash_deposit_id')->nullable();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cashier_register_closures');
    }
};
