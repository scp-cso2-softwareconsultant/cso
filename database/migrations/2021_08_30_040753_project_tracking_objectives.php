<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ProjectTrackingObjectives extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('project_tracking_objectives', function (Blueprint $table) {
            $table->id();
            $table->string('Objective');
            $table->string('indicators');
            $table->string('Implementation_vs_target');
            $table->string('challanges');
            $table->string('next_month_planning');
            $table->double('estimated_progress');
            $table->unsignedBigInteger('project_tracking_document_id');
            $table->foreign('project_tracking_document_id')->references('id')->on('project_tracking_document');
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_tracking_objectives');
    }
}
