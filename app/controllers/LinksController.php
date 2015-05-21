<?php

class LinksController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make("links.links-cadastro");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("links.links-cadastro");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{
		$input = Input::all();
		$validation = Validator::make($input, Link::$rules);

		if ($validation->passes()){
			$link = new Link;
			$link->name = Input::get("NomeExibicao");
			$link->url = Input::get("Url");
			$link->save();

			return Redirect::route('cadastra-links')
                        ->withErrors(['Cadastrado com sucesso...!']);
		}

		return Redirect::route('cadastra-links')
						->withInput()
						->withErrors($validation);
		
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('links.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('links.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function atualiza(){

		$input = Input::all();
		$link =  Link::find(Input::get("link_id"));

		$validation = Validator::make($input, Link::$rules);

		if ($validation->passes()){			
			$link->name = Input::get("NomeExibicao");
			$link->url = Input::get("Url");
			$link->save();

			return Redirect::route('cadastra-links')
                        ->withErrors(['Atualizado com sucesso...!']);
		}

		return Redirect::route('cadastra-links')
						->withInput()
						->withErrors($validation);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete()	{
		$link =  Link::find(Input::get("link_id"));
		$link->delete();
		return Redirect::route('cadastra-links');
	}

}
