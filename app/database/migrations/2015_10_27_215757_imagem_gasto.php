<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class ImagemGasto extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('imagem_gasto', function(Blueprint $table) {
			$table->increments('id');
			$table->string('path');
			$table->integer('id_gasto');
			$table->integer('id_nutricionista');
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
		Schema::drop('imagem_gasto');
	}

}
