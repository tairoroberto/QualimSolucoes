<?php

class CalendarioController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		if (Auth::user()->get()->type == "Administrador") {
			return View::make("calendario.calendario-admin");
		}
        return View::make("calendario.calendario");
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
       return View::make("calendario.calendario");
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store(){
		$calendario = new Calendario;
		$calendario->title = Input::get("title");
		$calendario->description = Input::get("description");
		$calendario->location = Input::get("location");
		$calendario->start = Input::get("start");
		$calendario->end = Input::get("end");
		$calendario->nutricionista_id = Auth::user()->get()->id;
		$calendario->situation = "";
		$calendario->save();
		return;
	}

	/**
	 * se for Admin repcorre o rercorre todas os eventos 
	 * e dentro do titulo mostra a concatenação de nome da consultora + titulo + descricao + local
	 * usa a funcão explode para capturar apena o primeiro nome da consultora
	 * 
	 * se não for admin mostara penas a concatenação de titulo + descricao + local
	 * 
	 * @param  int  $id
	 * @return json array com os eventos modificados
	 */
	public function mostrar($id){
		$array = array();
		if (Auth::user()->get()->type == "Administrador") {
			$result = Calendario::all();			
			foreach ($result as $evento) {				
				$nutricionista = Nutricionista::find($evento->nutricionista_id);
				$name = explode(" ", $nutricionista->name);

				$evento->title = $name[0]." - ".$evento->title ." - ".$evento->description." - ".$evento->location;
				$array[] = $evento;			
			}
         	return json_encode($array);
		}else{
			$result = Calendario::where('nutricionista_id','=',$id)->get();
         	foreach ($result as $evento) {
				$evento->title .= " - ".$evento->description." - ".$evento->location;
				$array[] = $evento;			
			}
         	return json_encode($array);
		}		
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function mostrarCronogramaLista(){
		/** if the user is admin go to cronogram list */
		if (Auth::user()->get()->type == "Administrador") {
			$nutricionistas = Nutricionista::all();
			return View::make('calendario.cronograma-lista',compact("nutricionistas"));

		}else{
			/** else goto user's cronogram*/
			$dataInicio = date('Y-m')."-01";
			$dataFim = date('Y-m')."-31";
                
			$cronogramas = Calendario::where('nutricionista_id','=',Auth::user()->get()->id)
									 ->where('start','>=',$dataInicio)
								     ->where('start','<=',$dataFim)
								     ->get();
			return View::make("calendario.cronograma-visualizar",compact("cronogramas"));	
		}	
         
	}


		/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function cronogramaDetalhe(){
		/** if the user is admin go to cronogram list */
		if (Input::get("nutricionista_id")) {
			$id = Input::get("nutricionista_id");

			$dataInicio = date('Y-m')."-01";
			$dataFim = date('Y-m')."-31";
			
			$cronogramas = Calendario::where('nutricionista_id','=',$id)
									 ->where('start','>=',$dataInicio)
								     ->where('start','<=',$dataFim)
								     ->get();
			return View::make("calendario.cronograma-visualizar",compact("cronogramas"));
		}
		         
	}




	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function edit($id)
	{
        return View::make('calendarios.edit');
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function atualizar(){

		$calendario = Calendario::find(Input::get("id"));
		$calendario->title = Input::get("title");
		$calendario->description = Input::get("description");
		$calendario->location = Input::get("location");
		$calendario->start = Input::get("start");
		$calendario->end = Input::get("end");
		$calendario->save();
		return;
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function delete(){
		$evento = Calendario::find(Input::get("id"));
		$evento->delete();
		return;
	}

}
