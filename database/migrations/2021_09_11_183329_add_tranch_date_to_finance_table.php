<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTranchDateToFinanceTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('finance', function (Blueprint $table) {
            //
            
            // $table->date('finance_tranche1_date');
            // $table->date('finance_tranche2_date');
            // $table->date('finance_tranche3_date');
            // $table->date('finance_tranche4_date');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('finance', function (Blueprint $table) {
            //
            $table->dropColumn('finance_tranche1_date');
            $table->dropColumn('finance_tranche2_date');
            $table->dropColumn('finance_tranche3_date');
            $table->dropColumn('finance_tranche4_date');
        });
    }
}
