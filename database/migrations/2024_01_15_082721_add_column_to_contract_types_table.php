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
        Schema::table('contract_types', function (Blueprint $table) {

            $table->integer('contract_hours')
                ->after('active');

            $table->integer('monthly_hours')
                ->after('contract_hours');

            $table->integer('weekly_hours_ls')
                ->after('monthly_hours');

            $table->integer('weekly_hours_hs')
                ->after('weekly_hours_ls');

            $table->integer('daily_hours')
                ->after('weekly_hours_hs');

            $table->float('holiday_per_month', 8, 2)
                ->after('daily_hours');

            $table->float('whr_per_month', 8, 2)
                ->after('holiday_per_month');

            $table->tinyInteger('priority')
                ->default(0)
                ->after('whr_per_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('contract_types', function (Blueprint $table) {
            $table->dropColumn(array_merge([
                'contract_hours',
                'monthly_hours',
                'weekly_hours_ls',
                'weekly_hours_hs',
                'daily_hours',
                'holiday_per_month',
                'whr_per_month',
                'priority',
            ]));
        });
    }
};
