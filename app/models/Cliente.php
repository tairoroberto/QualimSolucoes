<?php

class Cliente extends Eloquent{

use SoftDeletingTrait;

protected $table = "clientes";
protected $softDelete = true;
protected $dates = ['deleted_at'];

protected $guarded = array();
	
public static	$rules = array(
		'razaoSocial'				=>	'required|min:3',
		'nomeFantasia'				=>	'required|min:3',		
		'cnpj'				=>	'required|min:3',
		'endereco'  		=>	'required|min:3',		
		'numero'			=>	'alpha_num',		
		'bairro'			=>	'min:3',	
		'cidade'			=>	'min:3',	
		'telefone'			=>	'min:3',				
		'contato'			=>	'required|min:3',	
		'telefone_contato'  =>	'required|min:3',		
		'celular_contato'   =>	'min:3',		
		'email_contato'	    =>	'email',	
		'nutricionista_id'  =>	'required',
		'email'				=>	'email|required|unique:clientes,email',
		'senha'  =>  'required|min:3|confirmed',
		'senha_confirmation'  =>  'required|min:3|',	

	);



public function emails(){
		return $this->hasMany('EmailCliente');
	}
	
}