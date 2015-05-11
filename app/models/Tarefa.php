<?php

class Tarefa extends Eloquent {

    use SoftDeletingTrait;

	protected $table = "tarefas";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
	protected $guarded = array();

	public static $rules = array();


public function historico(){
		return $this->hasMany('TarefaHistorico');
	}
}
