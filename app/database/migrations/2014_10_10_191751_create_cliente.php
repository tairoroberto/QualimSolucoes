<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCliente extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create("clientes", function ($table){
			$table->increments('id');
			$table->string('razaoSocial',128);
			$table->string('nomeFantasia',128);
			$table->string('cnpj',20);
			$table->string('address',255);
			$table->string('number',50);
			$table->string('complement',255);
			$table->string('district',128);
			$table->string('city',100);
			$table->string('postal_code',20);
			$table->string('telephone',20);			
			$table->string('contact',255);
			$table->string('telephone_contact',20);
			$table->string('celphone_contact',20);
			$table->string('email_contact',255);
			// id da nutricionista responsavel pode conter varios nutricionistas
			//separados por virgula.
			$table->string('nutricionista_id',255); 
			$table->string('email',255);//email para login no sistema
			$table->string('password',60);
			$table->string('password_confirmation',60);			
			$table->string('type',50);
			$table->string('photo_logo',255);
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
		Schema::drop("clientes");
	}
}