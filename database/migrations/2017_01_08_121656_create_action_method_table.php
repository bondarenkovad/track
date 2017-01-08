<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActionMethodTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('action_method', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('method_id')->unsigned();
            $table->foreign('method_id')
                ->references('id')
                ->on('methods')
                ->onDelete('cascade')
                ->onUpdate('cascade');
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
        Schema::drop('action_method');
    }
}
