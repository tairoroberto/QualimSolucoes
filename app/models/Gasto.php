<?php

class Gasto extends Eloquent {

    use SoftDeletingTrait;

    protected $table = "gastos";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

	protected $guarded = array();

	public static $rules = array(
		'cliente-local'     		=>    'required',
		'hora-entrada'      		=>    'required',
		'hora-saida'    			=>    'required',
		'vale-refeicao'     		=>    'min:3',
		'observacaoValeTransporte'	=>	  'required|min:3',
		'vale-transporte'  			=>    'min:3',
		'observacaoGastoExtra'		=>    'min:3',
		'gasto-extra'    			=>    'min:3'
	);
}

