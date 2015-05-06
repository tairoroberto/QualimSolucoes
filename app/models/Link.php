<?php

class Link extends Eloquent {

    use SoftDeletingTrait;

	protected $table = 'links';
    protected $softDelete = true;
    protected $dates = ['deleted_at'];
	protected $guarded = array();

	public static $rules = array(
		'NomeExibicao'	=>'required|min:3|',
		'Url'			=>'required|min:3|url'
	);
}
