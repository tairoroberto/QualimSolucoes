<?php

class Calendario extends Eloquent {

    use SoftDeletingTrait;

	protected $table = "eventos";
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

	protected $guarded = array();

	public static $rules = array(

    );
	
}
