<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CrudGuard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('crud_guard', function (Blueprint $table) {
            $table->id();
            $table->boolean('create')->default(false);
            $table->boolean('read')->default(false);
            $table->boolean('update')->default(false);
            $table->boolean('delete')->default(false);
            
            $table->boolean('view')->default(false);
            $table->boolean('export')->default(false);
            $table->boolean('download')->default(false);
            $table->boolean('print')->default(false);
            $table->boolean('upload')->default(false);
            

            $table->unsignedBigInteger('roles_permission_id');
            $table->foreign('roles_permission_id')->references('id')->on('roles_permission');
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
        Schema::dropIfExists('crud_guard');
    }
}
