<?php

class EmailCliente extends Eloquent {

    use SoftDeletingTrait;

	protected $guarded = array();
	public $table = "email_clientes";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

	public static $rules = array();


	public function cliente(){
		return $this->belongsTo('Cliente');
	}
}
