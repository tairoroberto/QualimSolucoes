<?php

class RelatorioVisita extends Eloquent {

    use SoftDeletingTrait;

	protected $guarded = array();
	public $table = "relatorio_visitas";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

	public static $rules = array(
		'selectCliente'			=>	'required|min:1|',
		'selectNutricionista'	=>	'required|min:1|',
        'data'              	=>	'required',
        'horaInicio'			=>	'required|min:3|',
		'horaFim'				=>	'required|min:3|',
		'totalHoras'			=>	'required|min:3|',
		'relVisitaTecnica'		=>  'required|min:3|'
	);
}
