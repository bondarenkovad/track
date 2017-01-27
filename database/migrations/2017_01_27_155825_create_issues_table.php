<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('issues', function (Blueprint $table) {
            $table->increments('id');
            $table->string('summary',255);
            $table->text('description');
            $table->integer('status_id');
            $table->foreign('status_id')
                ->references('id')
                ->on('issue_statuses')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('project_id');
            $table->foreign('project_id')
                ->references('id')
                ->on('projects')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('type_id');
            $table->foreign('type_id')
                ->references('id')
                ->on('issue_types')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('priority_id');
            $table->foreign('priority_id')
                ->references('id')
                ->on('issues_priorities')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('reporter_id');
            $table->foreign('reporter_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('assigned_id');
            $table->foreign('assigned_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade')
                ->onUpdate('cascade');
            $table->integer('original_estimate');
            $table->integer('remaining_estimate');
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
        Schema::drop('issues');
    }
}
