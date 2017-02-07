<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_logs', function (Blueprint $table) {
            $table->bigIncrements('id')->unsigned();
            $table->text('comment');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('issue_id')->unsigned();
            $table->foreign('issue_id')
                ->references('id')
                ->on('issues')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('time_spent');
            $table->index('issue_status_id');
            $table->foreign('issue_status_id')
                ->references('id')
                ->on('issue_statuses')
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
        Schema::drop('work_logs');
    }
}
