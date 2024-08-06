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
        Schema::create('siae_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 100);
            $table->string('prefix', 10);
            $table->bigInteger('progressive');
            $table->integer('year');

            $table->float('price')->default(0);
            $table->float('fee')->default(0);
            $table->double('duty_stamp', 8, 2)->nullable()->default(0);

            // Definisci i vincoli di chiave esterna direttamente qui
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_type_id')->constrained()->onDelete('cascade');
            $table->foreignId('order_status_id')->constrained()->onDelete('cascade');
            $table->foreignId('payment_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('cashier_id')->nullable()->constrained()->onDelete('cascade');
            $table->foreignId('company_id')->nullable()->constrained()->onDelete('cascade');

            $table->boolean('can_modify')->default(true);
            $table->boolean('print_at_home')->default(true);
            $table->boolean('email_sent')->default(false);
            $table->string('email_to', 255)->nullable();
            $table->integer('printed_counter')->default(0);

            $table->timestamp('printed_at')->nullable();
            $table->timestamp('completed_at')->nullable();
            $table->timestamp('deleted_at')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            // Aggiungi l'indice su created_at qui
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siae_orders');
    }
};
