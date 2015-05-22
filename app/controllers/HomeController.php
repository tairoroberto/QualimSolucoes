<?php

class HomeController extends BaseController {

	//Login
	public function login(){
		return View::make("login");
	}

	//Master page
	public function index(){
		return View::make("index");
	}

    //Master page
    public function equipe(){
        return View::make("equipe");
    }



    //make logout of system
	public function makeLogout(){
		Auth::user()->logout();
		Auth::cliente()->logout();
		return Redirect::action("HomeController@login");
	}

}
