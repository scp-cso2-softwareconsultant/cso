<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToParticipantProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('participant_profile', function (Blueprint $table) {
            $table->string('name_of_training');
            $table->string('training_organizer');
         
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('participant_profile', function (Blueprint $table) {
            //
            $table->dropColumn('name_of_training');
            $table->dropColumn('training_organizer');
        });
    }
}
