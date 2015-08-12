<?php

class ClienteController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make('clientes.index');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create(){
		$nutricionistas = Nutricionista::all();
		return View::make("cliente.cliente-cadastro",compact("nutricionistas"));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function restoreClienteList(){
		$clientes = Cliente::onlyTrashed()->get();
		return View::make('cliente.cliente-lista-excluidos',compact("clientes"));
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		
		$input = Input::all();
		$validation = Validator::make($input, Cliente::$rules);
		$nutricionista_id = '';
		$photo_logo = "";

		if ($validation->passes()){	
			//store cliente
			/** get data sending from formulary and save in database*/

			//change the name of photo_logo for save in database			
			if (!is_null(Input::file('logo'))){
				$photo_logo = md5(uniqid(time())) . "." . Input::file('logo')->guessExtension();

				//move photo
				Input::file('logo')->move('packages/assets/img/logo-clientes',$photo_logo);				
			}
		

			$cliente = new Cliente;
			$cliente->razaoSocial = Input::get("razaoSocial");
			$cliente->nomeFantasia = Input::get("nomeFantasia");			
			$cliente->cnpj = Input::get("cnpj");			
			$cliente->address = Input::get("endereco");
			$cliente->number = Input::get("numero");
			$cliente->complement = Input::get("complemento");
			$cliente->district = Input::get("bairro");
			$cliente->city = Input::get("cidade");
			$cliente->postal_code = Input::get("cep");
			$cliente->telephone = Input::get("telefone");			
			$cliente->contact = Input::get("contato");
			$cliente->telephone_contact = Input::get("telefone_contato");
			$cliente->celphone_contact = Input::get("celular_contato");
			$cliente->email_contact = Input::get("email_contato");

			/** get a array and convert to string */	
			$ids = 	Input::get("nutricionista_id");	
			foreach ($ids as $id) {
				$nutricionista_id .= $id.",";
			}

			$cliente->nutricionista_id = $nutricionista_id;
			$cliente->email = Input::get("email");
			$cliente->password = Hash::make(Input::get("senha"));
			$cliente->password_confirmation = Hash::make(Input::get("senha_confirmation"));
			$cliente->type = "cliente";
			$cliente->photo_logo = $photo_logo;
			$cliente->remember_token = '';

			$cliente->save();


			/**
			 *verifica se emails foram submetidos 
			 */
			$emails = Input::get("emailArray");
			if (isset($emails)) {
				/** get array of emails and insert into table EmailCliente*/
				foreach ($emails as $email) {
					/**Verify if email is null*/
					if ($email != "") {
						$emailCliente = new EmailCliente;
						$emailCliente->email = $email;
						$emailCliente->cliente()->associate($cliente);
						$emailCliente->save();
					}					
				}
			}

						
			return Redirect::route('cadastra-cliente')			
						  ->withErrors(['Cliente Cadastrado com sucesso...!']);
		}

		return Redirect::route('cadastra-cliente')
						->withInput()
						->withErrors($validation);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show(){
		$clientes = Cliente::all();
		return View::make("cliente.cliente-lista",compact("clientes"));
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editar(){
		$cliente = null;

		if (Input::get("cliente_id")) {
			$cliente = Cliente::find(Input::get("cliente_id"));
		}elseif (Input::old("cliente_id")) {
			$cliente = Cliente::find(Input::old("cliente_id"));
		}
		
		return View::make("cliente.cliente-editar",compact("cliente"));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function atualizar(){
		$input = Input::all();
		$photo_logo = null;
		$rules = array(
		'razaoSocial'				=>	'required|min:3',
		'nomeFantasia'				=>	'required|min:3',		
		'cnpj'				=>	'required|min:3',
		'endereco'  		=>	'required|min:3',		
		'numero'			=>	'alpha_num',		
		'bairro'			=>	'min:3',	
		'cidade'			=>	'min:3',	
		'telefone'			=>	'min:3',				
		'contato'			=>	'required|min:3',	
		'telefone_contato'  =>	'required|min:3',		
		'celular_contato'   =>	'min:3',		
		'email_contato'	    =>	'email',	
		'nutricionista_id'  =>	'required',
		'email'				=>	'required|min:3|',
		'senha'  =>  'required|min:3|confirmed',
		'senha_confirmation'  =>  'required|min:3|',
		);


		$validation = Validator::make($input, $rules);
		$cliente = Cliente::findOrFail(Input::get("cliente_id"));
		if ($validation->passes()){

			//change the name of photo for save in database
			//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
			if((!is_null(Input::file('logo'))) && (File::exists('packages/assets/img/logo-clientes/'.$cliente->photo_logo))){
				File::delete('packages/assets/img/logo-clientes/'.$cliente->photo_logo);
			}	


			if (!is_null(Input::file('logo'))) {
				//change the name of photo for save in database
				$photo_logo = md5(uniqid(time())) . "." . Input::file('logo')->guessExtension();
				//move photo
				Input::file('logo')->move('packages/assets/img/logo-clientes/',$photo_logo);			
			}


			//store cliente
			$cliente->razaoSocial = Input::get("razaoSocial");
			$cliente->nomeFantasia = Input::get("nomeFantasia");			
			$cliente->cnpj = Input::get("cnpj");			
			$cliente->address = Input::get("endereco");
			$cliente->number = Input::get("numero");
			$cliente->complement = Input::get("complemento");
			$cliente->district = Input::get("bairro");
			$cliente->city = Input::get("cidade");
			$cliente->postal_code = Input::get("cep");
			$cliente->telephone = Input::get("telefone");			
			$cliente->contact = Input::get("contato");
			$cliente->telephone_contact = Input::get("telefone_contato");
			$cliente->celphone_contact = Input::get("celular_contato");
			$cliente->email_contact = Input::get("email_contato");

			/** get a array and convert to string */
			$nutricionista_id = '';	
			$ids = 	Input::get("nutricionista_id");	
			foreach ($ids as $id) {
				$nutricionista_id .= $id.",";
			}

			$cliente->nutricionista_id = $nutricionista_id;
			$cliente->email = Input::get("email");
			$cliente->password = Hash::make(Input::get("senha"));
			$cliente->password_confirmation = Hash::make(Input::get("senha_confirmation"));
			$cliente->type = "cliente";
			if (!is_null(Input::file('logo'))) {$cliente->photo_logo = $photo_logo;}
			$cliente->remember_token = '';

			$cliente->save();


			/**
			 *verifica se emails já cadastrados foram submetidos
			 */
			$emails = Input::get("emailArray");
			$idEmail = Input::get("idEmail");
			$i = 0;
            $j = 0;

			if (isset($emails,$idEmail)) {
				/** get array of emails and insert into table EmailCliente*/
				while (($i < count($emails)) && ($j < $emails)) {

					/**Verify if email is null*/
						$emailCliente = EmailCliente::find($idEmail[$j]);

						if($emails[$i] != ""){
                            $emailCliente->email = $emails[$i];
                            $emailCliente->save();
                        }else{
                            $emailCliente->delete($idEmail[$j]);
                        }

					$i++;
					$j++;	
				}
			}


            /**
             *verifica se emails novos foram submetidos
             */
            $emails = Input::get("emailNovoArray");
            if (isset($emails)) {
                /** get array of emails and insert into table EmailCliente*/
                foreach ($emails as $email) {
                    /**Verify if email is null*/
                    if ($email != "") {
                        $emailCliente = new EmailCliente;
                        $emailCliente->email = $email;
                        $emailCliente->cliente()->associate($cliente);
                        $emailCliente->save();
                    }
                }
            }

			return Redirect::route('editar-cliente')
						  ->withInput()			
						  ->withErrors(['Cliente editado com sucesso...!']);
		}

		return Redirect::route('editar-cliente')
						->withInput()
						->withErrors($validation);
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id){
		$cliente = Cliente::find($id);

		//change the name of photo for save in database
		//verifica se enviada uma imagem, se enviada deleta a antiga e salva a nova imagem
		if(File::exists('packages/assets/img/logo-clientes/'.$cliente->photo_logo)){
			File::delete('packages/assets/img/logo-clientes/'.$cliente->photo_logo);
		}	

		$cliente->delete();
		return Redirect::route('visualizar-cliente');
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function restoreCliente($id)	{
		$cliente = Cliente::withTrashed()->find($id);
		$cliente->restore();
		return Redirect::route('clientes-excluidos')
			->withErrors(['Cliente restaurado com sucesso...!']);
	}



	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function buscaDados(){
		try {
			$dadosEmpresa = CnpjGratis::consulta(
		    Input::get("cnpj"),
		    Input::get("captcha"),
		    //Input::get("viewstate"),
		    Input::get("cookie")
			);

			if ($dadosEmpresa['nome_fantasia'] == "undefined" && $dadosEmpresa['razao_social'] = "undefined" ) {
				echo "Captcha incorreto";
			}else{
				echo json_encode($dadosEmpresa);
			}		
		
		} catch (Exception $e) {
			echo "Captcha incorreto";
		}
	}

}
