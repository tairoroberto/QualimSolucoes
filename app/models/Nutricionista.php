<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class Nutricionista extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;
    use SoftDeletingTrait;

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'nutricionistas';
    protected $softDelete = true;
    protected $dates = ['deleted_at'];

	/**
	 * The attributes excluded from the model's JSON form.
	 *
	 * @var array
	 */
	protected $hidden = array('password', 'remember_token');

	protected $guarded = array();

	public static $rules = array(
			'nome'  =>  'required|min:3|',
			'senha'  =>  'required|min:3|confirmed',
			'senha_confirmation'  =>  'required|min:3|',
			'endereco'  =>  'required|min:3|',
			'cep'  =>  'min:3|',
			'email'  =>  'required|email|unique:nutricionistas,email',
			'bairro' => 'min:3',
			'cidade' => 'min:3',
			'foto'   => 'required',
			'tipo' => 'required'
			);


}
