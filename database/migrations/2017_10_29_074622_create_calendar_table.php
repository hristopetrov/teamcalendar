<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendar', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->index();
            $table->integer('user_id')->unsigned();
            $table->smallInteger('project_id')->unsigned()->nullable();
            $table->smallInteger('client_id')->unsigned()->nullable();
            $table->decimal('length',2,1)->default(1);
            $table->enum('away',['vacation','sick','other'])->nullable();
            $table->string('comment',160)->nullable();
            $table->timestamp('added_on');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
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
        Schema::dropIfExists('calendar');
    }
}
