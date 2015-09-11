<?php

class GastosController extends BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
         $nutricionistas = Nutricionista::where('type','!=','Cliente')->get();	
         if (Auth::user()->get()->type =="Administrador") {
         	return View::make("gastos.gastos-lista",compact('nutricionistas'));
         }

        $mesInicio = date('Y-m')."-01";
		$mesFim = date('Y-m')."-31";

		$gastos = Gasto::where('nutricionista_id','=',Auth::user()->get()->id)
					   ->where('date','>=',$mesInicio)
					   ->where('date','<=',$mesFim)
					   ->get();

		$nutricionista_id = Auth::user()->get()->id;			   
        return View::make('gastos.gastos-mes-lista',compact(array('gastos','nutricionista_id')));
		
	}


	

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
        return View::make('gastos.gastos');
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()	{

		$input = Input::all();
		$validation = Validator::make($input, Gasto::$rules);

		if ($validation->passes())
		{	
			$calendario = Calendario::find(Input::get("calendario_id"));
            $calendario->situation = "Despesa cadastrada";
            $calendario->save();

			$gasto = new Gasto;
			$gasto->client_locale = Input::get("cliente-local");

            $date = explode("-",Input::get("date"));

            $gasto->date = $date[2]."-".$date[1]."-".$date[0]." ".Input::get("hora-entrada");
			$gasto->entry_time = Input::get("hora-entrada");
			$gasto->departure_time = Input::get("hora-saida");
			$gasto->meal_voucher = Input::get("vale-refeicao");
			$gasto->observation_transport = Input::get("observacaoValeTransporte");
			$gasto->transport_voucher = Input::get("vale-transporte");
			$gasto->observation_extra_expense = Input::get("observacaoGastoExtra");
			$gasto->extra_expense = Input::get("gasto-extra");
            $gasto->calendario_id = $calendario->id;
            $gasto->nutricionista_id = Input::get("nutricionista_id");

			$gasto->save();
			
			return Redirect::route('cadastrar-gastos')
						  ->withErrors(['Despesa Cadastrada com sucesso...!']);
		}

		return Redirect::route('cadastrar-gastos')
						->withInput()
						->withErrors($validation);	
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function mostrar(){
		$mesInicio = date('Y-m')."-01";
		$mesFim = date('Y-m')."-31";
		$nutricionista_id = Input::get("nutricionista_id");
		$gastos = Gasto::where('nutricionista_id','=',Input::get("nutricionista_id"))
					   ->where('date','>=',$mesInicio)
					   ->where('date','<=',$mesFim)
					   ->get();

        return View::make('gastos.gastos-mes-lista',compact(array('gastos','nutricionista_id')));
	}

	/**
	 * Display the specified resource.
	 *
	 * @return Response
	 */
	public function mostrarBusca(){

		$mes = Input::get("SelectMes");
		$ano = Input::get("SelectAno");
		$mesBusca = $mes;
		$anoBusca = $ano;
		$mesInicio = $ano."-".$mes."-01";
		$mesFim = $ano."-".$mes."-31";
		$nutricionista_id = Input::get("nutricionista_id");
		$gastos = Gasto::where('nutricionista_id','=',Input::get("nutricionista_id"))
					   ->where('date','>=',$mesInicio)
					   ->where('date','<=',$mesFim)
					   ->get();

        return View::make('gastos.gastos-mes-busca',compact(array('gastos','nutricionista_id', 'mesBusca', 'anoBusca')));

	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @return Response
	 */
	public function edit(){

        $input = Input::all();
        $validation = Validator::make($input, Gasto::$rules);

        if ($validation->passes()){

            $calendario = Calendario::find(Input::get("calendario_id"));
            $calendario->situation = "Despesa cadastrada e editada";


            $gasto = Gasto::find(Input::get("gasto_id"));
            $gasto->client_locale = Input::get("cliente-local");

            $date = explode("-",Input::get("date"));

            $gasto->date = $date[2]."-".$date[1]."-".$date[0]." ".Input::get("hora-entrada");
			$calendario->start = $date[2]."-".$date[1]."-".$date[0]." ".Input::get("hora-entrada");

            $gasto->entry_time = Input::get("hora-entrada");
            $gasto->departure_time = Input::get("hora-saida");
            $gasto->meal_voucher = Input::get("vale-refeicao");
            $gasto->observation_transport = Input::get("observacaoValeTransporte");
            $gasto->transport_voucher = Input::get("vale-transporte");
            $gasto->observation_extra_expense = Input::get("observacaoGastoExtra");
            $gasto->extra_expense = Input::get("gasto-extra");
            $gasto->calendario_id = Input::get("calendario_id");

			$calendario->save();
            $gasto->save();

            return Redirect::route('cadastrar-gastos')
                ->withErrors(['Despesa editada com sucesso...!']);
        }

        return Redirect::route('cadastrar-gastos')
            ->withInput()
            ->withErrors($validation);
    }



	/**
	 * Update the specified resource in storage.
	 *
	 * @return Response
	 */
	public function imprimir()
	{
		$mes = Input::get("SelectMes");
		$ano = Input::get("SelectAno");
        $mesBusca = $mes;
        $anoBusca = $ano;

		$mesInicio = $ano."-".$mes."-01";
		$mesFim = $ano."-".$mes."-31";
		$nutricionista_id = Input::get("nutricionista_id");
		$gastos = Gasto::where('nutricionista_id','=',Input::get("nutricionista_id"))
			->where('date','>=',$mesInicio)
			->where('date','<=',$mesFim)
			->get();

		return View::make('gastos.gastos-imprimir',compact(array('gastos','nutricionista_id', 'mesBusca', 'anoBusca')));
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @return Response
	 */
	public function destroy()
	{

        if(Input::get('calendario_id') != '' && Input::get('gasto_id') != ''){
            $gasto = Gasto::find(Input::get('gasto_id'));
            $calendario = Calendario::find(Input::get('calendario_id'));

            $gasto->forceDelete();
            $calendario->forceDelete();

            return Redirect::route('cadastrar-gastos')
                ->withErrors(['Despesa deletada com sucesso...!']);
        }

        $calendario = Calendario::find(Input::get('calendario_id'));

        $calendario->forceDelete();

        return Redirect::route('cadastrar-gastos')
            ->withErrors(['Despesa deletada com sucesso...!']);

	}

}
