<?php

class TarefasController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return View::make("tarefa.tarefa-nova");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make("tarefa.tarefa-nova");
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function createCliente()
    {
        return View::make("tarefa.tarefa-nova-cliente");
    }


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function createDetails()
	{
        return View::make("tarefa.tarefa-visualizar");
	}



	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){

		$input = Input::all();
		$validation = Validator::make($input, Tarefa::$rules);

		if ($validation->passes())
		{	
			//store Etapa tarefa
            $tarefa = new Tarefa;
            $tarefa->nutricionista_id = Input::get("SelectResponsavel1");
            $tarefa->cliente_id = 0;
            $tarefa->to = 'nutricionista';
            $tarefa->title = Input::get("TituloTarefa1");
            $tarefa->description = Input::get("Descricaotarefa1");
            $tarefa->date_start = Input::get("DataInicio");
            $tarefa->date_finish = Input::get("DataEntregaTarefa1");;
            $tarefa->SituacaoEtapaTarefa = "";
            $tarefa->MotivoPrazoEtapaTarefa = "";
            $tarefa->save();


			$historicoTarefa = new TarefaHistorico;
            $historicoTarefa->tarefa_id = $tarefa->id;
			$historicoTarefa->historico = "Tarefa cadastrada";
			$historicoTarefa->save();


			$SelectUsuarioArray = Input::get("SelectUsuarioArray");
			$TituloArray = Input::get("TituloArray");
			$DescricaoArray = Input::get("DescricaoArray");
			$DataEntregaArray = Input::get("DataEntregaArray");
			$i = 0;
	   		$j = 0;
	   		$k = 0;
	   		$l = 0;

			if ($SelectUsuarioArray != "") {
				while($i < count($SelectUsuarioArray) && $j < count($TituloArray) && 
   			 		  $k < count($DescricaoArray) && $l < count($DataEntregaArray)){   	 				

   			
					//store Etapa tarefa
                    $tarefa = new Tarefa;
                    $tarefa->nutricionista_id = $SelectUsuarioArray[$i];
                    $tarefa->cliente_id = 0;
                    $tarefa->to = 'nutricionista';
                    $tarefa->title = $TituloArray[$j];
                    $tarefa->description = $DescricaoArray[$k];
                    $tarefa->date_start = Input::get("DataInicio");
                    $tarefa->date_finish = $DataEntregaArray[$l];
                    $tarefa->SituacaoEtapaTarefa = "";
                    $tarefa->MotivoPrazoEtapaTarefa = "";
                    $tarefa->save();

					$historicoTarefa = new TarefaHistorico;
                    $historicoTarefa->tarefa_id = $tarefa->id;
					$historicoTarefa->historico = "Tarefa cadastrada";
					$historicoTarefa->save();
			   			
	   				$i++;
	   				$j++;
	   				$k++;
	   				$l++;
   				}
			}
									
			return Redirect::route('cadastra-tarefas')
                            ->withErrors(['Cadastrado com sucesso...!']);

		}

		return Redirect::route('cadastra-tarefas')
						->withInput()
						->withErrors($validation);
	}




    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function storeCliente(){

        $input = Input::all();
        $validation = Validator::make($input, Tarefa::$rules);

        if ($validation->passes())
        {
            //store Etapa tarefa
            $tarefa = new Tarefa;
            $tarefa->nutricionista_id = Input::get("SelectResponsavel1");
            $tarefa->cliente_id = Input::get("SelectCliente1");
            $tarefa->to = 'cliente';
            $tarefa->title = Input::get("TituloTarefa1");
            $tarefa->description = Input::get("Descricaotarefa1");
            $tarefa->date_start = Input::get("DataInicio");
            $tarefa->date_finish = Input::get("DataEntregaTarefa1");;
            $tarefa->SituacaoEtapaTarefa = "";
            $tarefa->MotivoPrazoEtapaTarefa = "";
            $tarefa->save();


            $historicoTarefa = new TarefaHistorico;
            $historicoTarefa->tarefa_id = $tarefa->id;
            $historicoTarefa->historico = "Tarefa cadastrada";
            $historicoTarefa->save();


            $SelectUsuarioArray = Input::get("SelectUsuarioArray");
            $SelectClienteArray = Input::get("SelectClienteArray");
            $TituloArray = Input::get("TituloArray");
            $DescricaoArray = Input::get("DescricaoArray");
            $DataEntregaArray = Input::get("DataEntregaArray");
            $i = 0;
            $j = 0;
            $k = 0;
            $l = 0;
            $m = 0;

            if ($SelectUsuarioArray != "") {
                while($i < count($SelectUsuarioArray) && $j < count($TituloArray) &&
                    $k < count($DescricaoArray) && $l < count($DataEntregaArray)){


                    //store Etapa tarefa
                    $tarefa = new Tarefa;
                    $tarefa->nutricionista_id = $SelectUsuarioArray[$i];
                    $tarefa->cliente_id = $SelectClienteArray[$j];
                    $tarefa->to = 'cliente';
                    $tarefa->title = $TituloArray[$k];
                    $tarefa->description = $DescricaoArray[$l];
                    $tarefa->date_start = Input::get("DataInicio");
                    $tarefa->date_finish = $DataEntregaArray[$m];
                    $tarefa->SituacaoEtapaTarefa = "";
                    $tarefa->MotivoPrazoEtapaTarefa = "";
                    $tarefa->save();

                    $historicoTarefa = new TarefaHistorico;
                    $historicoTarefa->tarefa_id = $tarefa->id;
                    $historicoTarefa->historico = "Tarefa cadastrada";
                    $historicoTarefa->save();

                    $i++;
                    $j++;
                    $k++;
                    $l++;
                    $m++;
                }
            }

            return Redirect::route('cadastra-tarefas')
                ->withErrors(['Cadastrado com sucesso...!']);

        }

        return Redirect::route('cadastra-tarefas')
            ->withInput()
            ->withErrors($validation);
    }


    /**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function show()
	{
        //return View::make('tarefa.tarefa-visualizar');
        return View::make("tarefa.tarefa-visualizar");
	}

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function showTarefasCliente()
    {
        //return View::make('tarefa.tarefa-visualizar');
        return View::make("tarefa.tarefa-cliente-visualizar");
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function showTarefasAdminCliente()
    {
        //return View::make('tarefa.tarefa-visualizar');
        return View::make("tarefa.tarefa-cliente-admin-visualizar");
    }



	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function showFinish()
	{
        return View::make('tarefa.tarefa-finalizadas');
	}



	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editar($id){
		$tarefa = Tarefa::findOrFail($id);
        return View::make('tarefa.tarefa-editar',compact("tarefa"));
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function atualizar()	{
		//store Etapa tarefa
        $tarefa = Tarefa::findOrFail(Input::get("tarefa_id"));
        $tarefa->nutricionista_id = Input::get("SelectResponsavel1");
        $tarefa->cliente_id = 0;
        $tarefa->title = Input::get("TituloTarefa1");
        $tarefa->description = Input::get("Descricaotarefa1");
        $tarefa->date_start = Input::get("DataInicio");
        $tarefa->date_finish = Input::get("DataEntregaTarefa1");;
        $tarefa->SituacaoEtapaTarefa = "";
        $tarefa->save();

		$historicoTarefa = new TarefaHistorico;
        $historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Tarefa atualizada";
		$historicoTarefa->save();

		return Redirect::route('visualizar-tarefas');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function finalizar($id){
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Finalizado";
		$tarefa->save();

		$historicoTarefa = new TarefaHistorico;
        $historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Tarefa Finalizada";
		$historicoTarefa->save();

        if($tarefa->to == "cliente"){
            return Redirect::route('visualizar-tarefas-cliente')
                ->withErrors(['Tarefa finalizada com sucesso...!']);
        }

        return Redirect::route('visualizar-tarefas')
            ->withErrors(['Tarefa finalizada com sucesso...!']);

	}

		/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function solicitarPrazo(){
		$id = Input::get("tarefa_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Solicitar prazo";
		$tarefa->MotivoPrazoEtapaTarefa = Input::get("motivoPrazo");
		$tarefa->save();

		$historicoTarefa = new TarefaHistorico;
		$historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Prazo Solicitado: Motivo : ".Input::get("motivoPrazo");
		$historicoTarefa->save();

        $alert = new Alerta;

        if(Input::get("pagina_cliente") != ""){
            $alert->nutricionista_id = 0;
            $alert->cliente_id = Auth::cliente()->get()->id;
            $alert->msg = "Cliente solicita prazo";

            $alert->admin = 0;
            $alert->url = action("TarefasController@showTarefasAdminCliente");
            $alert->situation = "";
            $alert->save();


            return Redirect::route('visualizar-tarefas-cliente');
        }else{
            $alert->nutricionista_id = $tarefa->nutricionista_id;
            $alert->cliente_id = 0;
            $alert->msg = "Consultora solicita prazo";

            $alert->admin = 0;
            $alert->url = action("TarefasController@show");
            $alert->situation = "";
            $alert->save();


            return Redirect::route('visualizar-tarefas');
        }
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function negarPrazo(){
		$id = Input::get("tarefaNegarPrazo_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Prazo negado";
		$tarefa->save();

		$historicoTarefa = new TarefaHistorico;
        $historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Solicitação de prazo negada";
		$historicoTarefa->save();


        if(Input::get("pagina_cliente") != ""){
            $alert = new Alerta;
            $alert->nutricionista_id = 0;
            $alert->cliente_id = $tarefa->cliente_id;
            $alert->msg = "Prazo de tarefa foi negado";

            $alert->admin = 0;
            $alert->url = action("TarefasController@showTarefasCliente");
            $alert->situation = "mostrar-para-usuario";
            $alert->save();


            return Redirect::route('visualizar-tarefas-admim-cliente');

        }else{
            $alert = new Alerta;
            $alert->nutricionista_id = $tarefa->nutricionista_id;
            $alert->cliente_id = 0;
            $alert->admin = Auth::user()->get()->id;
            $alert->msg = "Prazo de tarefa foi negado";
            $alert->url = action("TarefasController@show");
            $alert->situation = "mostrar-para-usuario";
            $alert->save();


            return Redirect::route('visualizar-tarefas');
        }

	}




	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function concederPrazo(){
		$id = Input::get("tarefaPrazo_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Prazo concedido";
		$tarefa->date_finish = Input::get("dataPrazo");
		$tarefa->save();

		$historicoTarefa = new TarefaHistorico;
        $historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Prazo concedido até : ".$tarefa->date_finish;
		$historicoTarefa->save();

        $alert = new Alerta;
        $alert->nutricionista_id = $tarefa->nutricionista_id;
        $alert->cliente_id = 0;
        $alert->admin = 0;
        $alert->msg = "Prazo de tarefa concedito";
        $alert->url = action("TarefasController@show");
        $alert->situation = "";
        $alert->save();

		return Redirect::route('visualizar-tarefas');
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id){
		$tarefa = Tarefa::find($id);

		$historicoTarefa = TarefaHistorico::where('tarefa_id','=',$tarefa->id)->get()->first();
        $historicoTarefa->tarefa_id = $tarefa->id;
		$historicoTarefa->historico = "Tarefa cadastrada";
		$historicoTarefa->save();
        $tarefa->delete($id);
		return Redirect::route('visualizar-tarefas');
	}

}
