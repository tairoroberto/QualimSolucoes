<?php

class QualimAndroidController extends BaseController {

	/**
	 * Function that verify the login of android app
	 *
	 * @return Response
	 */
	public function loginAndroid(){
		$credentials = Input::only("email","password");

		if (Auth::user()->attempt($credentials)) { 
			echo  utf8_decode(Auth::user()->get()->id.",".Auth::user()->get()->name.",".Auth::user()->get()->email);
		}else{
			echo "Login incorreto"; 
		}
	}

	/**
	 * Function that verify the logout of android app
	 *
	 * @return Response
	 */
	public function logoutAndroid(){		
		Auth::user()->logout();
		echo  "Desconectado";		
	}


	/**
	 * Function that store user's expenses of android app
	 *
	 * @return Response
	 */
	public function storeExpenseAndroid(){		
		$gasto = new Gasto;

		//converte a moeda
		$vrAux = str_replace("." , ',' , Input::get("vale-refeicao")); 
		$vtAux = str_replace("." , ',' , Input::get("vale-transporte"));  
		$gastoAux = str_replace("." , ',' , Input::get("gasto-extra"));  
        

		$gasto->client_locale = Input::get("cliente-local");
		$gasto->entry_time = Input::get("hora-entrada");
		$gasto->departure_time = Input::get("hora-saida");
		$gasto->meal_voucher = $vrAux;
		$gasto->observation_transport = Input::get("observacaoValeTransporte");
		$gasto->transport_voucher = $vtAux;
		$gasto->observation_extra_expense = Input::get("observacaoGastoExtra");
		$gasto->extra_expense = $gastoAux;
		$gasto->nutricionista_id = Input::get("nutricionista_id");	
		
		if ($gasto->save()) {
			echo "Saved";
		}else{
			echo "Don't saved";
		}				
	}


	/**
	 * Function that show user's expenses of android app
	 *
	 * @return Json Array
	 */
	public function showExpenseAndroid(){	

		$nutricionista = Nutricionista::find(Input::get("nutricionista_id"));

		$mesInicio = date('Y-m')."-01";
		$mesFim = date('Y-m')."-31";
		$gastos = Gasto::where('nutricionista_id','=',Input::get("nutricionista_id"))
					   ->where('created_at','>=',$mesInicio)
					   ->where('created_at','<=',$mesFim)
					   ->get();		

		echo $gastos->toJson();	 
	}


	/**
	 * Function that store user's events of android app
	 *
	 * @return Json Array
	 */
	public function storeEventsAndroid(){	

		$calendario = new Calendario;
		$calendario->title = Input::get("title");
		$calendario->description = Input::get("description");
		$calendario->location = Input::get("location");
		$calendario->start = Input::get("start");
		$calendario->end = Input::get("end");
		$calendario->nutricionista_id = Input::get("nutricionista_id");
		$calendario->allDay = 0;	
		
		if ($calendario->save()) {
			echo "Saved";
		}else{
			echo "Not Saved";
		}		
	}

	/**
	 * Function that show user's events of android app
	 *
	 * @return Json Array
	 */
	public function showEventsAndroid(){	
		/** else goto user's cronogram*/
		$dataInicio = date('Y-m')."-01";
		$dataFim = date('Y-m')."-31";
            
		$cronogramas = Calendario::where('nutricionista_id','=',Input::get("nutricionista_id"))
								 ->where('start','>=',$dataInicio)
							     ->where('start','<=',$dataFim)
							     ->get();
		echo $cronogramas->toJson();	 
	}

	/**
	 * Function that show user's events of android app
	 *
	 * @return Json Array
	 */
	public function storePhoto(){	
		$photo_name="";	
		$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));

		$photo_name = md5(uniqid(time())) . "." . $_POST['img-mime'];
		if (isset($_POST['img-image']) && (File::exists('packages/assets/img/profiles/'.$nutricionista->photo))) {
			File::delete('packages/assets/img/profiles/'.$nutricionista->photo);
			$binary = base64_decode($_POST['img-image']);
			$file = fopen('packages/assets/img/profiles/'.$photo_name, 'wb');
			fwrite($file, $binary);
			fclose($file);
			$nutricionista->photo = $photo_name;
		}

		if ($nutricionista->save()) {
			return "Saved";
		}else{
			return "Not Saved";
		}	
	}



	/**
	 * Function that show user's events of android app
	 *
	 * @return Json Array
	 */
	public function showPhoto(){	
		/** else goto user's cronogram*/
		 
	}


	/**
	 * Function that show user's events of android app
	 *
	 * @return Json Array
	 */
	public function storeSignature(){	
		$photo_signature="";	
		$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));

		$photo_signature = md5(uniqid(time())) . "." . $_POST['img-mime'];
		if (isset($_POST['img-image']) && (File::exists('packages/assets/img/signatures/'.$nutricionista->signature))) {
			File::delete('packages/assets/img/signatures/'.$nutricionista->signature);
			$binary = base64_decode($_POST['img-image']);
			$file = fopen('packages/assets/img/signatures/'.$photo_signature, 'wb');
			fwrite($file, $binary);
			fclose($file);
			$nutricionista->signature = $photo_signature;
		}

		if ($nutricionista->save()) {
			return "Saved";
		}else{
			return "Not Saved";
		}	
	}

	/**
	 * Function that show user's events of android app
	 *
	 * @return Json Array
	 */
	public function changePassword(){	
		/** else goto user's cronogram*/
		$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));
		$nutricionista->password = Hash::make(Input::get("senha"));
		$nutricionista->password_confirmation = Hash::make(Input::get("senha_confirmation"));

		if ($nutricionista->save()) {
			return "Saved";
		}else{
			return "Not Saved";
		}
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function relatorioVisitaTecnicaCad(){
		if (Input::get("nutricionista_id")) {
			$nutricionista = Nutricionista::findOrFail(Input::get("nutricionista_id"));       
       		 return View::make('android.relatorio-visita-tecnica-cad',compact('nutricionista'));
		}else{
			return View::make('android.relatorio-visita-tecnica-cad');
		}
	}


		/**
	 * Store a new relatory
	 *
	 * @return Response
	 */
	public function storeVisitaTecnicaAndroid()
	{

		$input = Input::all();
		$validation = Validator::make($input, RelatorioVisita::$rules);

		if ($validation->passes()){
			$relatorio_visita = new RelatorioVisita;
			$relatorio_visita->nutricionista_id = Input::get("selectNutricionista");
			$relatorio_visita->cliente_id = Input::get("cliente_id");
            $relatorio_visita->data = Input::get("data")." 00:00:00";
			$relatorio_visita->hora_inicio = Input::get("horaInicio");
			$relatorio_visita->hora_fim = Input::get("horaFim");
			$relatorio_visita->hora_total = Input::get("totalHoras");
			$relatorio_visita->relatorio = Input::get("relVisitaTecnica");
			$relatorio_visita->save();


            return 'Relatório cadastrado com sucesso..!!!';

        }
		return Redirect::to('relatorio-visita-tecnica-cad-android')
						->withInput()
						->withErrors($validation);

	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		//
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
        return View::make('qualimandroids.show');
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('qualimandroids.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

}
