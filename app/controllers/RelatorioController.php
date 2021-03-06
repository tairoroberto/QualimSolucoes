<?php

class RelatorioController extends BaseController {

	/**
	 * Se o ususario logado for o Admin ou supervisora, irá mostar uma lista com todos
	 * os relatórios de visitas técnicas feitos
	 * se o usuario logado for uma consultora, irá mostrar apenas os seus relatórios
	 *
	 * @return Lista de relatórios de visistas tectnicas
	 */
	public function index()	{

		if (Auth::user()->check()) {
			if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Supervisora")) {
			 $relatorio_visitas = RelatorioVisita::all(); 
			 return View::make("relatorio-visita.relatorio-visita-tecnica-lista",compact("relatorio_visitas"));
		    }
		   $relatorio_visitas = RelatorioVisita::where('nutricionista_id','=',Auth::user()->get()->id)->get();
	       return View::make("relatorio-visita.relatorio-visita-tecnica-lista",compact("relatorio_visitas"));

		}elseif (Auth::cliente()->check()) {
			$relatorio_visitas = RelatorioVisita::where('cliente_id','=',Auth::cliente()->get()->id)->get();
	       return View::make("relatorio-visita.relatorio-visita-tecnica-lista",compact("relatorio_visitas"));
		}else{
			return Redirect::to("login");
		}
		
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("relatorio-visita.relatorio-visita-tecnica-cadastrar");
	}

    /**
     * Store a newly created resource in storage.
     * @return Response
     * @internal param $relatorio
     */
	public function visualizarRelatorioEmail()
	{
        Auth::user()->logout();
        Auth::cliente()->logout();
        $relatorio_visita = RelatorioVisita::find(Input::get('relatorio'));

        if(Input::get('user') == 'cliente'){
            Auth::cliente()->loginUsingId(Input::get('cliente_id'));
            $relatorio_visita->lido = 1;
            $relatorio_visita->save();
        }else{
            Auth::user()->loginUsingId(Input::get('logged'));
        }



        return View::make("relatorio-visita.relatorio-visita-tecnica-vizulizar", compact("relatorio_visita"));
	}


	/**
	 * Store a new relatory
	 *
	 * @return Response
	 */
	public function storeVisitaTecnica()
	{

		$input = Input::all();
		$validation = Validator::make($input, RelatorioVisita::$rules);

		if ($validation->passes()){

                $relatorio_visita = new RelatorioVisita;
                $relatorio_visita->nutricionista_id = Input::get("selectNutricionista");
                $relatorio_visita->cliente_id = Input::get("cliente_id");

                $data = explode("/", Input::get("data"));
                $relatorio_visita->data = $data[2]."-".$data[1]."-".$data[0]." 00:00:00";

                $relatorio_visita->hora_inicio = Input::get("horaInicio");
                $relatorio_visita->hora_fim = Input::get("horaFim");
                $relatorio_visita->hora_total = Input::get("totalHoras");
                $relatorio_visita->relatorio = Input::get("relVisitaTecnica");
                $relatorio_visita->save();

                $nutricionista = Nutricionista::find(Input::get("selectNutricionista"));
                $cliente = Cliente::find(Input::get("cliente_id"));


                /**
                 *verifica se AS FOTOS foram submetidos
                 */
                $fotos = Input::file("FotosArray");
                if (isset($fotos)) {
                    foreach ($fotos as $foto) {
                        //change the name of photo for save in database
                        $ext = $foto->guessExtension();

                        if($ext == ""){
                            $ext = pathinfo($foto->getClientOriginalName(), PATHINFO_EXTENSION);
                        }
                            $photo_name = md5(uniqid(time())) . "." . $ext;

                            //move photo
                            $foto->move('packages/assets/img/relatorios',$photo_name);
                            $fotoRelatorio = new FotosRelatorio;
                            $fotoRelatorio->foto = $photo_name;
                            $fotoRelatorio->relatorio_id = $relatorio_visita->id;
                            $fotoRelatorio->save();
                    }
                }

                try{
                    /*send email to nutricionist and client*/
                    Mail::send('emails.relatorio-email-nutricionista', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($nutricionista)
                    {
                        $message->to($nutricionista->email, $nutricionista->name)->subject('Relatório Qualim Soluções');
                    });


                    /**Busca todos os email do cliente para envio*/
                    $emailsCliente = EmailCliente::where('cliente_id', '=', $cliente->id)->get();
                    $emailsClienteEnvio = array();

                    foreach($emailsCliente as $emailCliente){
                        $emailsClienteEnvio[] = $emailCliente->email;
                    }
                    $emailsClienteEnvio[] = $cliente->email;


                    /*send email to  client*/
                    Mail::send('emails.relatorio-email-cliente', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($cliente, $emailsClienteEnvio)
                    {
                        $message->to($emailsClienteEnvio, $cliente->nomeFantasia)->subject('Relatório Qualim Soluções');
                    });

                }catch (Exception $e){
                    return Redirect::route('relatorio-lista')
                        ->withInput()
                        ->withErrors(['Relatório salvo, porém emails não foram enviados!']);
                }


                return Redirect::route('relatorio')
                               ->withErrors(['Relatório salvo com sucesso!']);

		}		
		return Redirect::route('relatorio')
						->withInput()
						->withErrors($validation);

	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function imprimir(){
		
		$relatorio_visita = RelatorioVisita::find(Input::get("relatorio_id"));

        if (Auth::user()->check()) {
            return View::make("relatorio-visita.relatorio-visita-tecnica-imprimir",compact("relatorio_visita"));
            //return PDF_2::createFromView(View::make("relatorio-visita.relatorio-visita-tecnica-visualizar",compact("relatorio_visita")), 'filename.pdf');


        }elseif (Auth::cliente()->check()) {
            $relatorio_visita->lido = 1;
            $relatorio_visita->save();
            return View::make("relatorio-visita.relatorio-visita-tecnica-imprimir",compact("relatorio_visita"));
            //return PDF_2::createFromView(View::make("relatorio-visita.relatorio-visita-tecnica-visualizar",compact("relatorio_visita")), 'filename.pdf');
        }
    }


    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function visulaizar(){

        $relatorio_visita = RelatorioVisita::find(Input::get("relatorio_id"));

        if (Auth::user()->check()) {
            return View::make("relatorio-visita.relatorio-visita-tecnica-vizulizar",compact("relatorio_visita"));
            //return PDF_2::createFromView(View::make("relatorio-visita.relatorio-visita-tecnica-visualizar",compact("relatorio_visita")), 'filename.pdf');

        }elseif (Auth::cliente()->check()) {
            $relatorio_visita->lido = 1;
            $relatorio_visita->save();
            return View::make("relatorio-visita.relatorio-visita-tecnica-vizulizar",compact("relatorio_visita"));
            //return PDF_2::createFromView(View::make("relatorio-visita.relatorio-visita-tecnica-visualizar",compact("relatorio_visita")), 'filename.pdf');
        }
    }



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit()
	{
        $relatorio = RelatorioVisita::find(Input::get("relatorio_id"));
        $nutricionista  = Nutricionista::withTrashed()->find($relatorio->nutricionista_id);
        $cliente  = Cliente::find($relatorio->cliente_id);
        return View::make('relatorio-visita.relatorio-visita-tecnica-editar',compact("relatorio", "nutricionista","cliente"));
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function update()
	{
        $input = Input::all();
        $validation = Validator::make($input, RelatorioVisita::$rules);

        if ($validation->passes()){

                $relatorio_visita = RelatorioVisita::find(Input::get("relatorio_id"));
                $relatorio_visita->nutricionista_id = Input::get("selectNutricionista");
                $relatorio_visita->cliente_id = Input::get("cliente_id");

                $data = explode("/", Input::get("data"));
                $relatorio_visita->data = $data[2]."-".$data[1]."-".$data[0]." 00:00:00";

                $relatorio_visita->hora_inicio = Input::get("horaInicio");
                $relatorio_visita->hora_fim = Input::get("horaFim");
                $relatorio_visita->hora_total = Input::get("totalHoras");
                $relatorio_visita->relatorio = Input::get("relVisitaTecnica");
                $relatorio_visita->save();

                $nutricionista = Nutricionista::withTrashed()->find(Input::get("selectNutricionista"));
                $cliente = Cliente::find(Input::get("cliente_id"));

                /**
                 *verifica se AS FOTOS foram submetidos
                 */
                $fotos = Input::file("FotosArray");
                if (isset($fotos)) {
                    foreach ($fotos as $foto) {
                        //change the name of photo for save in database
                        $photo_name = md5(uniqid(time())) . "." . $foto->guessExtension();

                        //move photo
                        $foto->move('packages/assets/img/relatorios',$photo_name);
                        $fotoRelatorio = new FotosRelatorio;
                        $fotoRelatorio->foto = $photo_name;
                        $fotoRelatorio->relatorio_id = $relatorio_visita->id;
                        $fotoRelatorio->save();
                    }
                }

                try{
                    /*send email to nutricionist and client*/
                    Mail::send('emails.relatorio-email-nutricionista', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($nutricionista)
                    {
                        $message->to($nutricionista->email, $nutricionista->name)->subject('Relatório Qualim Soluções');
                    });


                    /**Busca todos os email do cliente para envio*/
                    $emailsCliente = EmailCliente::where('cliente_id', '=', $cliente->id)->get();
                    $emailsClienteEnvio = array();

                    foreach($emailsCliente as $emailCliente){
                        $emailsClienteEnvio[] = $emailCliente->email;
                    }
                    $emailsClienteEnvio[] = $cliente->email;

                    /*send email to  client*/
                    Mail::send('emails.relatorio-email-cliente', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($cliente, $emailsClienteEnvio)
                    {
                        $message->to($emailsClienteEnvio, $cliente->nomeFantasia)->subject('Relatório Qualim Soluções');
                    });

                }catch (Exception $e){
                    return Redirect::route('relatorio-lista')
                        ->withInput()
                        ->withErrors(['Relatório salvo porém emails não foram enviados!']);
                }


                return Redirect::route('relatorio-lista')
                    ->withErrors(['Relatório editado com sucesso!']);

        }
        return Redirect::route('relatorio-lista')
            ->withInput()
            ->withErrors($validation);
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

    /**
     * Remove the specified resource from storage.
     *
     * @return Response
     */
    public function deletarFotoRelatorio()
    {
        $fotoRelatorio = FotosRelatorio::find(Input::get("foto_id"));
        if(File::exists("packages/assets/img/relatorios/".$fotoRelatorio->foto)){
            File::delete("packages/assets/img/relatorios/".$fotoRelatorio->foto);

            if($fotoRelatorio->delete()){
                return Redirect::route('relatorio-lista')
                               ->withInput()
                               ->withErrors(['Foto de relatório deletada com sucesso!']);
            }
        }


        return Redirect::route('relatorio-lista')
                       ->withInput()
                       ->withErrors(['Foto de relatório não foi deletada!']);

    }

    public function reenviarEmails(){

        $relatorio_visita = RelatorioVisita::find(Input::get("relatorio_id"));
        $nutricionista  = Nutricionista::withTrashed()->find($relatorio_visita->nutricionista_id);
        $cliente  = Cliente::withTrashed()->find($relatorio_visita->cliente_id);

        try{
            /*send email to nutricionist and client*/
            Mail::send('emails.relatorio-email-nutricionista', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($nutricionista)
            {
                $message->to($nutricionista->email, $nutricionista->name)->subject('Relatório Qualim Soluções');
            });


            /**Busca todos os email do cliente para envio*/
            $emailsCliente = EmailCliente::where('cliente_id', '=', $cliente->id)->get();
            $emailsClienteEnvio = array();

            foreach($emailsCliente as $emailCliente){
                $emailsClienteEnvio[] = $emailCliente->email;
            }
            $emailsClienteEnvio[] = $cliente->email;

            /*send email to  client*/
            Mail::send('emails.relatorio-email-cliente', array('nutricionista' => $nutricionista,'cliente' => $cliente, 'relatorio' => $relatorio_visita), function($message) use ($cliente, $emailsClienteEnvio)
            {
                $message->to($emailsClienteEnvio, $cliente->nomeFantasia)->subject('Relatório Qualim Soluções');
            });

            return Redirect::route('relatorio-lista')
                ->withInput()
                ->withErrors(['Emails reenviados com sucesso!']);

        }catch (Exception $e){
            return Redirect::route('relatorio-lista')
                ->withInput()
                ->withErrors(['Emails não foram enviados!']);
        }
    }

}
