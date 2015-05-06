<?php

class Tarefa_historico extends Eloquent {

    use SoftDeletingTrait;

	protected $guarded = array();
	protected $table = "tarefa_historicos";
    protected $dates = ['deleted_at'];
    protected $softDelete = true;

	public static $rules = array();

	public function tarefa(){
		return $this->belongsTo('Tarefa');
	}
}
