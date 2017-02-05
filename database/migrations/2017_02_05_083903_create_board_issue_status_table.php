<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardIssueStatusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('board_issue_status', function (Blueprint $table) {
            $table->index('board_id')->unsigned();
            $table->foreign('board_id')
                ->references('id')
                ->on('boards')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->index('issue_status_id');
            $table->foreign('issue_status_id')
                ->references('id')
                ->on('issue_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->tinyInteger('order');
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
        Schema::drop('board_issue_status');
    }
}
