<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("nutricionistas", function ($table){
			$table->increments('id');
			$table->string('name',255);			
			$table->string('password',60);			
			$table->string('password_confirmation',60);
			$table->string('address',255);
			$table->string('number',60);
			$table->string('complement',255);
			$table->string('district',255);
			$table->string('city',255);
			$table->string('postal_code',10);
			$table->string('telephone',20);
			$table->string('celphone',20);
			$table->string('email',255);
			$table->string('type',255);
			$table->integer('num_ticket');
			$table->string('photo',255);
			$table->string('signature',255);
			$table->string('color',10);
			$table->string('remember_token',60);
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
		Schema::drop("users");
	}

}
