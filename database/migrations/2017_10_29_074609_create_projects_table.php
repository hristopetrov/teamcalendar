<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->smallIncrements('id');
            $table->smallInteger('client_id')->unsigned();
            $table->string('name',30);
            $table->string('color',6)->default('acb6e5');
            $table->smallInteger('budgeted')->default(0);
            $table->date('deadline')->nullable();
            $table->boolean('active')->default(1)->index();
            $table->timestamp('added_on');
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('projects');
    }
}
