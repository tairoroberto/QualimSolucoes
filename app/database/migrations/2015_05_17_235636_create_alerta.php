<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateAlerta extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('alerta', function(Blueprint $table) {
			$table->increments('id');
            $table->integer('nutricionista_id');
            $table->integer('cliente_id');
            $table->integer('admin');
            $table->string('msg');
            $table->string('url');
            $table->string('situation');
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
		Schema::drop('alerta');
	}

}
