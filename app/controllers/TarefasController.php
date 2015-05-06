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
			$etapaTarefa = new Tarefa;
			$etapaTarefa->nutricionista_id = Input::get("SelectResponsavel1");
			$etapaTarefa->title = Input::get("TituloTarefa1");
			$etapaTarefa->description = Input::get("Descricaotarefa1");
			$etapaTarefa->date_start = Input::get("DataInicio");
			$etapaTarefa->date_finish = Input::get("DataEntregaTarefa1");;
			$etapaTarefa->SituacaoEtapaTarefa = "";
			$etapaTarefa->MotivoPrazoEtapaTarefa = "";
			$etapaTarefa->save();


			$historicoTarefa = new Tarefa_historico;
			$historicoTarefa->tarefa()->associate($etapaTarefa);
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
					$etapaTarefa = new Tarefa;
					$etapaTarefa->nutricionista_id = $SelectUsuarioArray[$i];
					$etapaTarefa->title = $TituloArray[$j];
					$etapaTarefa->description = $DescricaoArray[$k];
					$etapaTarefa->date_start = Input::get("DataInicio");
					$etapaTarefa->date_finish = $DataEntregaArray[$l];
					$etapaTarefa->SituacaoEtapaTarefa = "";
					$etapaTarefa->MotivoPrazoEtapaTarefa = "";
					$etapaTarefa->save();

					$historicoTarefa = new Tarefa_historico;
					$historicoTarefa->tarefa()->associate($etapaTarefa);
					$historicoTarefa->historico = "Tarefa cadastrada";
					$historicoTarefa->save();
			   			
	   				$i++;
	   				$j++;
	   				$k++;
	   				$l++; 			
   				}
			}
									
			return Redirect::route('cadastra-tarefas');

		}

		return Redirect::route('cadastra-tarefas')
						->withInput()
						->withErrors($validation);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
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
	 * @param  int  $id
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
	 * @param  int  $id
	 * @return Response
	 */
	public function atualizar()	{
		//store Etapa tarefa
		$etapaTarefa = Tarefa::findOrFail(Input::get("tarefa_id"));
		$etapaTarefa->nutricionista_id = Input::get("SelectResponsavel1");
		$etapaTarefa->title = Input::get("TituloTarefa1");
		$etapaTarefa->description = Input::get("Descricaotarefa1");
		$etapaTarefa->date_start = Input::get("DataInicio");
		$etapaTarefa->date_finish = Input::get("DataEntregaTarefa1");;
		$etapaTarefa->SituacaoEtapaTarefa = "";
		$etapaTarefa->save();

		$historicoTarefa = new Tarefa_historico;
		$historicoTarefa->tarefa()->associate($etapaTarefa);
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

		$historicoTarefa = new Tarefa_historico;
		$historicoTarefa->tarefa()->associate($tarefa);
		$historicoTarefa->historico = "Tarefa Finalizada";
		$historicoTarefa->save();

		return Redirect::route('visualizar-tarefas');
	}

		/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function solicitarPrazo(){
		$id = Input::get("tarefa_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Solicitar prazo";
		$tarefa->MotivoPrazoEtapaTarefa = Input::get("motivoPrazo");
		$tarefa->save();

		$historicoTarefa = new Tarefa_historico;
		$historicoTarefa->tarefa()->associate($tarefa);
		$historicoTarefa->historico = "Prazo Solicitado";
		$historicoTarefa->save();

		return Redirect::route('visualizar-tarefas');
	}



	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function negarPrazo(){
		$id = Input::get("tarefaNegarPrazo_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Prazo negado";
		$tarefa->save();

		$historicoTarefa = new Tarefa_historico;
		$historicoTarefa->tarefa()->associate($tarefa);
		$historicoTarefa->historico = "Solicitação de prazo negada";
		$historicoTarefa->save();

		return Redirect::route('visualizar-tarefas');
	}




	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function concederPrazo(){
		$id = Input::get("tarefaPrazo_id");
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->SituacaoEtapaTarefa = "Prazo concedido";
		$tarefa->date_finish = Input::get("dataPrazo");
		$tarefa->save();

		$historicoTarefa = new Tarefa_historico;
		$historicoTarefa->tarefa()->associate($tarefa);
		$historicoTarefa->historico = "Prazo concedido até : ".$tarefa->date_finish;
		$historicoTarefa->save();

		return Redirect::route('visualizar-tarefas');
	}



	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete($id){
		$tarefa = Tarefa::findOrFail($id);
		$tarefa->delete();

		$historicoTarefa = Tarefa_historicofindOrFail('tarefa_id','=',$id);;
		$historicoTarefa->tarefa()->associate($etapaTarefa);
		$historicoTarefa->historico = "Tarefa cadastrada";
		$historicoTarefa->save();
		return Redirect::route('visualizar-tarefas');
	}

}
