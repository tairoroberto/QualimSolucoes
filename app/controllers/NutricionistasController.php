<?php

class NutricionistasController extends BaseController {


	protected $nutricionista;

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('nutricionista.nutricionista-cadastro');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('nutricionista.nutricionista-cadastro');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		
		$input = Input::all();

	
		$validation = Validator::make($input, Nutricionista::$rules);

		if ($validation->passes()){	
			
		$photo_name = "";
		$photo_signature = "";

			//change the name of photo for save in database			
			if (!is_null(Input::file('foto'))){
				$photo_name = md5(uniqid(time())) . "." . Input::file('foto')->guessExtension();

				//move photo
				Input::file('foto')->move('packages/assets/img/profiles',$photo_name);				
			}
			

			if(!is_null(Input::file('assinatura'))){							
				$photo_signature = md5(uniqid(time())) . "." . Input::file('assinatura')->guessExtension();

				//move assinatura
				Input::file('assinatura')->move('packages/assets/img/signatures',$photo_signature);
			}

			$nutricionista = new Nutricionista;
			$nutricionista->name = Input::get("nome");
			$nutricionista->password = Hash::make(Input::get("senha"));
			$nutricionista->password_confirmation = Hash::make(Input::get("senha_confirmation"));
			$nutricionista->address = Input::get("endereco");
			$nutricionista->number = Input::get("numero");
			$nutricionista->complement = Input::get("complemento");
			$nutricionista->district = Input::get("bairro");
			$nutricionista->city = Input::get("cidade");
			$nutricionista->postal_code = Input::get("cep");
			$nutricionista->telephone = Input::get("telefone");
			$nutricionista->celphone = Input::get("celular");
			$nutricionista->email = Input::get("email");
			$nutricionista->type = Input::get("tipo");
			$nutricionista->num_ticket = Input::get("ticket");
			$nutricionista->photo = $photo_name;
			$nutricionista->signature = $photo_signature;
			$nutricionista->remember_token = "";

			$nutricionista->save();
			
			return Redirect::route('index')		
						  ->withErrors(['Consultora cadastrada com sucesso...!']);
		}

		return Redirect::route('cadastra-usuario')
						->withInput()
						->withErrors($validation);	
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show(){
		$nutricionistas = Nutricionista::all();
		return View::make("nutricionista.nutricionista-lista", compact('nutricionistas'));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function restoreUserList(){
        $nutricionistas = Nutricionista::onlyTrashed()->get();
        return View::make('nutricionista.nutricionista-lista-excluidos',compact("nutricionistas"));
	}

    /**
     * Show the form for editing the specified resource.
     *
     * @return Response
     */
    public function edit(){
        $nutricionista = Nutricionista::find(Input::get("nutricionista_id"));
        return View::make('nutricionista.nutricionista-editar',compact("nutricionista"));
    }

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function editConta(){
		return View::make('nutricionista.nutricionista-edita-conta');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function atualizaNutricionista(){
		
		$photo_name = null;
		$photo_signature = null;

		$input = Input::all();

		$rules = array(
			'nome'  =>  'required|min:3|',
			'senha'  =>  'required|min:3|confirmed',
			'senha_confirmation'  =>  'required|min:3|',
			'endereco'  =>  'required|min:3|',
			'cep'  =>  'min:3|',
			'email'  =>  'required|email',
			'bairro' => 'min:3',
			'cidade' => 'min:3',
			'tipo' => 'required'
			);

		$validation = Validator::make($input, $rules);
		//pega a nutricinista
		$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));

		if ($validation->passes()){


			//change the name of photo for save in database
			//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
			if((!is_null(Input::file('foto'))) && (File::exists('packages/assets/img/profiles/'.$nutricionista->photo))){
				File::delete('packages/assets/img/profiles/'.$nutricionista->photo);
			}	

			//change the name of photo for save in database
			//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
			if((!is_null(Input::file('assinatura'))) && (File::exists('packages/assets/img/signatures/'.$nutricionista->signature))){
				File::delete('packages/assets/img/signatures/'.$nutricionista->signature);
			}	



			if (!is_null(Input::file('foto'))) {
				//change the name of photo for save in database
				$photo_name = md5(uniqid(time())) . "." . Input::file('foto')->guessExtension();
				//move photo
				Input::file('foto')->move('packages/assets/img/profiles/',$photo_name);			
			}

			if (!is_null(Input::file('assinatura'))) {
				//change the name of photo for save in database
				$photo_signature = md5(uniqid(time())) . "." . Input::file('assinatura')->guessExtension();
				//move photo
				Input::file('assinatura')->move('packages/assets/img/signatures/',$photo_signature);
			}
						
					
			
			$nutricionista->name = Input::get("nome");
			$nutricionista->password = Hash::make(Input::get("senha"));
			$nutricionista->password_confirmation = Hash::make(Input::get("senha_confirmation"));
			$nutricionista->address = Input::get("endereco");
			$nutricionista->number = Input::get("numero");
			$nutricionista->complement = Input::get("complemento");
			$nutricionista->district = Input::get("bairro");
			$nutricionista->city = Input::get("cidade");
			$nutricionista->postal_code = Input::get("cep");
			$nutricionista->telephone = Input::get("telefone");
			$nutricionista->celphone = Input::get("celular");
			$nutricionista->email = Input::get("email");
			$nutricionista->type = Input::get("tipo");
			$nutricionista->num_ticket = Input::get("ticket");
			if (!is_null(Input::file('foto'))) {$nutricionista->photo = $photo_name;}
			if (!is_null(Input::file('assinatura'))) {$nutricionista->signature = $photo_signature;}			
			$nutricionista->remember_token = "";

			$nutricionista->save();
			
			return Redirect::route('editar-usuario')
						  ->withInput()			
						  ->withErrors(['Consultora cadastrada com sucesso...!']);
		}

		return Redirect::route('editar-usuario',compact('nutricionista'))
						->withInput()
						->withErrors($validation);	
	}



	/**
	 * Update the specified Nutricionis in storage.
	 * filds eamil,type and nu_ticket are disabled
	 *
	 * @return Response
	 */
	public function atualizaContaNutricionista(){
		
		$photo_name = null;
		$photo_signature = null;

		$input = Input::all();

		$rules = array(
			'nome'  =>  'required|min:3|',
			'senha'  =>  'required|min:3|confirmed',
			'senha_confirmation'  =>  'required|min:3|',
			'endereco'  =>  'required|min:3|',
			'cep'  =>  'min:3|',
			'email'  =>  'required|email',
			'bairro' => 'min:3',
			'cidade' => 'min:3',
			);

		$validation = Validator::make($input, $rules);
		//pega a nutricinista
		$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));

		if ($validation->passes()){


			//change the name of photo for save in database
			//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
			if((!is_null(Input::file('foto'))) && (File::exists('packages/assets/img/profiles/'.$nutricionista->photo))){
				File::delete('packages/assets/img/profiles/'.$nutricionista->photo);
			}	

			//change the name of photo for save in database
			//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
			if((!is_null(Input::file('assinatura'))) && (File::exists('packages/assets/img/signatures/'.$nutricionista->signature))){
				File::delete('packages/assets/img/signatures/'.$nutricionista->signature);
			}	



			if (!is_null(Input::file('foto'))) {
				//change the name of photo for save in database
				$photo_name = md5(uniqid(time())) . "." . Input::file('foto')->guessExtension();
				//move photo
				Input::file('foto')->move('packages/assets/img/profiles/',$photo_name);			
			}

			if (!is_null(Input::file('assinatura'))) {
				//change the name of photo for save in database
				$photo_signature = md5(uniqid(time())) . "." . Input::file('assinatura')->guessExtension();
				//move photo
				Input::file('assinatura')->move('packages/assets/img/signatures/',$photo_signature);
			}
						
					
			
			$nutricionista->name = Input::get("nome");
			$nutricionista->password = Hash::make(Input::get("senha"));
			$nutricionista->password_confirmation = Hash::make(Input::get("senha_confirmation"));
			$nutricionista->address = Input::get("endereco");
			$nutricionista->number = Input::get("numero");
			$nutricionista->complement = Input::get("complemento");
			$nutricionista->district = Input::get("bairro");
			$nutricionista->city = Input::get("cidade");
			$nutricionista->postal_code = Input::get("cep");
			$nutricionista->telephone = Input::get("telefone");
			$nutricionista->celphone = Input::get("celular");
			$nutricionista->email = Input::get("email");
			/*$nutricionista->type = Input::get("tipo");
			$nutricionista->num_ticket = Input::get("ticket");*/
			if (!is_null(Input::file('foto'))) {$nutricionista->photo = $photo_name;}
			if (!is_null(Input::file('assinatura'))) {$nutricionista->signature = $photo_signature;}			
			$nutricionista->remember_token = "";

			$nutricionista->save();
			
			return Redirect::route('editar-usuario-conta')
						  ->withInput()			
						  ->withErrors(['Consultora editada com sucesso...!']);
		}

		return Redirect::route('editar-usuario-conta',compact('nutricionista'))
						->withInput()
						->withErrors($validation);	
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id)	{
		$nutricionista = Nutricionista::find($id);
		//change the name of photo for save in database
		//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
		if(File::exists('packages/assets/img/profiles/'.$nutricionista->photo)){
			File::delete('packages/assets/img/profiles/'.$nutricionista->photo);
		}	

		//change the name of photo for save in database
		//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
		if(File::exists('packages/assets/img/signatures/'.$nutricionista->signature)){
			File::delete('packages/assets/img/signatures/'.$nutricionista->signature);
		}	

		$nutricionista->delete();
		return Redirect::route('visualizar-usuario')
            ->withErrors(['Consultora deletada com sucesso...!']);
	}



    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function restoreUser($id)	{
        $nutricionista = Nutricionista::withTrashed()->find($id);
        $nutricionista->restore();
        return Redirect::route('usuarios-excluidos')
            ->withErrors(['Consultora restaurada com sucesso...!']);
    }

}
