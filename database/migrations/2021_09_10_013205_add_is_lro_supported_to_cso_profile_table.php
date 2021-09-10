<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIsLroSupportedToCsoProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('cso_profile', function (Blueprint $table) {
            $table->string('is_lro_supported');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('cso_profile', function (Blueprint $table) {
            $table->dropColumn('is_lro_supported');
        });
    }
}
