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
        Schema::table('products', function (Blueprint $table) {
            $table->foreign(['product_subcategory_id'])->references(['id'])->on('product_subcategories')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['service_id'])->references(['id'])->on('services')->onUpdate('NO ACTION')->onDelete('CASCADE');
            $table->foreign(['supplier_id'])->references(['id'])->on('users')->onUpdate('NO ACTION')->onDelete('SET NULL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropForeign('products_product_subcategory_id_foreign');
            $table->dropForeign('products_service_id_foreign');
            $table->dropForeign('products_supplier_id_foreign');
        });
    }
};
