<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->timestamps();
        });

        Schema::create('action_property_group', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('property_group_id')->unsigned();
            $table->foreign('property_group_id')
                ->references('id')
                ->on('property_groups')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('action_id')->unsigned();
            $table->foreign('action_id')
                ->references('id')
                ->on('actions')
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
        Schema::drop('property__groups');
    }
}
