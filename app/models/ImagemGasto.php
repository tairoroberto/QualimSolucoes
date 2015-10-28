<?php

class ImagemGasto extends Eloquent {
	protected $guarded = array();
	protected $table = "imagem_gasto";
	protected $dates = ['deleted_at'];
	public static $rules = array();
}
