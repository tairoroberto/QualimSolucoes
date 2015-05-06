<?php

class EtapaTarefa extends Eloquent {
    use SoftDeletingTrait;

	protected $guarded = array();
	protected $table = "etapa_tarefa";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];


	public static $rules = array();

	public function tarefa(){
		return $this->belongsTo('Tarefa');
	}

}
