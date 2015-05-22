<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateTarefas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('tarefas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('nutricionista_id');
            $table->integer('cliente_id');
            $table->string('to');
			$table->string('title');
			$table->string('description');
			$table->string('date_start');
			$table->string('date_finish');
			$table->string('SituacaoEtapaTarefa');
			$table->string('MotivoPrazoEtapaTarefa');
			$table->timestamps();
            $table->softDeletes();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('tarefas');
	}

}
