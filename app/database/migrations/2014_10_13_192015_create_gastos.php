<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGastos extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('gastos', function(Blueprint $table) {
			$table->increments('id');
			$table->string('client_locale');
            $table->dateTime('date');
			$table->string('entry_time');
			$table->string('departure_time');
			$table->string('meal_voucher');
			$table->string('observation_transport');
			$table->string('transport_voucher');
			$table->string('observation_extra_expense');
			$table->string('extra_expense');
            $table->integer('calendario_id');
			$table->integer('nutricionista_id');
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
		Schema::drop('gastos');
	}

}
