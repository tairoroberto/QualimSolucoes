<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateRelatorioVisitas extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('relatorio_visitas', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('nutricionista_id');
			$table->integer('cliente_id');
            $table->dateTime('data');
			$table->string('hora_inicio');
			$table->string('hora_fim');
			$table->string('hora_total');
			$table->longText('relatorio');
			$table->integer('lido');
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
		Schema::drop('relatorio_visitas');
	}

}
