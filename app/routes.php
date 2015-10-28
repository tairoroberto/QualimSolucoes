<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/
Route::model("nutricionista", "Nutricionista");
Route::model("cliente", "Cliente");


//route of login
Route::get("/", "HomeController@login");
Route::get("/public", "HomeController@login");
Route::get("/login", "HomeController@login");

Route::post("/login", function () {
    $credentials = Input::only("email", "password");
    $remember = Input::has("remember");


    if ((Auth::user()->attempt($credentials, $remember)) || (Auth::cliente()->attempt($credentials, $remember))) {
        return Redirect::intended("/index");
    }
    return Redirect::to("login")
        ->with('flash_error', 1)
        ->withInput();

});


Route::group(array('before' => 'auth'), function () {

//create the views
    Route::get("/index", array(
        'as' => "index",
        "uses" => "HomeController@index"
    ));

//create the views
    Route::get("/equipe", array(
        'as' => "equipe",
        "uses" => "HomeController@equipe"
    ));


    Route::get("/cadastra-usuario", array(
        'as' => 'cadastra-usuario',
        'uses' => 'NutricionistasController@create'
    ));

    Route::get("/visualizar-usuario", array(
        'as' => 'visualizar-usuario',
        'uses' => 'NutricionistasController@show'
    ));

    Route::get('/editar-usuario', array(
        'as' => 'editar-usuario',
        'uses' => 'NutricionistasController@edit'
    ));

    Route::post('/editar-usuario', array(
        'as' => 'editar-usuario',
        'uses' => 'NutricionistasController@edit'
    ));

    Route::get('/editar-usuario-conta', array(
        'as' => 'editar-usuario-conta',
        'uses' => 'NutricionistasController@editConta'
    ));

    Route::get('/usuarios-excluidos', array(
        'as' => 'usuarios-excluidos',
        'uses' => 'NutricionistasController@restoreUserList'
    ));

    Route::get("/visualizar-usuario", array(
        'as' => 'visualizar-usuario',
        'uses' => 'NutricionistasController@show'
    ));

    Route::get("/cadastra-cliente", array(
        'as' => 'cadastra-cliente',
        'uses' => 'ClienteController@create'
    ));

    Route::get("/visualizar-cliente", array(
        'as' => 'visualizar-cliente',
        'uses' => 'ClienteController@show'
    ));

    Route::get('/editar-cliente', array(
        'as' => 'editar-cliente',
        'uses' => 'ClienteController@editar'
    ));

    Route::post('/editar-cliente', array(
        'as' => 'editar-cliente',
        'uses' => 'ClienteController@editar'
    ));

    Route::get('/clientes-excluidos', array(
        'as' => 'clientes-excluidos',
        'uses' => 'ClienteController@restoreClienteList'
    ));

    Route::get("/cadastra-links", array(
        'as' => 'cadastra-links',
        'uses' => 'LinksController@create'
    ));

    Route::get("/cadastra-tarefas", array(
        'as' => 'cadastra-tarefas',
        'uses' => 'TarefasController@create'
    ));

    Route::get("/cadastra-tarefas-cliente", array(
        'as' => 'cadastra-tarefas-cliente',
        'uses' => 'TarefasController@createCliente'
    ));

    Route::get("/visualizar-tarefas", array(
        'as' => 'visualizar-tarefas',
        'uses' => 'TarefasController@show'
    ));

    Route::get("/visualizar-tarefas-cliente", array(
        'as' => 'visualizar-tarefas-cliente',
        'uses' => 'TarefasController@showTarefasCliente'
    ));

    Route::get("/visualizar-tarefas-admim-cliente", array(
        'as' => 'visualizar-tarefas-admim-cliente',
        'uses' => 'TarefasController@showTarefasAdminCliente'
    ));

    Route::get("/visualizar-tarefas-finalizadas", array(
        'as' => 'visualizar-tarefas-finalizadas',
        'uses' => 'TarefasController@showFinish'
    ));

    Route::get("/tarefa-detahe", array(
        'as' => 'tarefa-detahe',
        'uses' => 'TarefasController@createDetails'
    ));

    Route::get("/calendario", array(
        'as' => 'calendario',
        'uses' => 'CalendarioController@create'
    ));

    Route::get("/calendario-individual", array(
        'as' => 'calendario-individual',
        'uses' => 'CalendarioController@indexIndividual'
    ));

    Route::get("/cronograma-lista", array(
        'as' => 'cronograma-lista',
        'uses' => 'CalendarioController@mostrarCronogramaLista'
    ));

    Route::get("/relatorio", array(
        'as' => 'relatorio',
        'uses' => 'RelatorioController@create'
    ));

    Route::get("/relatorio-lista", array(
        'as' => 'relatorio-lista',
        'uses' => 'RelatorioController@index'
    ));

    Route::get("/cadastrar-gastos", array(
        'as' => 'cadastrar-gastos',
        'uses' => 'GastosController@create'
    ));

    Route::get("/visualizar-gastos", array(
        'as' => 'visualizar-gastos',
        'uses' => 'GastosController@index'
    ));



//Route for submission User
    Route::post("/cadastra-usuario", "NutricionistasController@store");
    Route::post("/atualizar-usuario", "NutricionistasController@atualizaNutricionista");
    Route::post("/atualizar-usuario-conta", "NutricionistasController@atualizaContaNutricionista");
    Route::get("/deletar-usuario/{id}", "NutricionistasController@delete");
    Route::get("/restaurar-usuario/{id}", "NutricionistasController@restoreUser");

//Route for submision client
    Route::post("/cadastra-cliente", "ClienteController@store");
    Route::post("/atualizar-cliente", "ClienteController@atualizar");
    Route::post("/busca-dados-cliente", "ClienteController@buscaDados");
    Route::get("/deletar-cliente/{id}", "ClienteController@delete");
    Route::get("/restaurar-cliente/{id}", "ClienteController@restoreCliente");

//Route for submission Links
    Route::post("/cadastra-links", "LinksController@store");
    Route::post("/atualiza-links", "LinksController@atualiza");
    Route::post("/deletar-links", "LinksController@delete");

//Route for calender
    Route::get("/visualizar-eventos/{id}", "CalendarioController@mostrar");
    Route::get("/visualizar-eventos-individual/{id}", "CalendarioController@mostrarIdnvidual");
    Route::post("/adicionar-eventos", "CalendarioController@store");
    Route::post("/atualizar-eventos", "CalendarioController@atualizar");
    Route::post("/atualizar-eventos-drop", "CalendarioController@atualizarDrop");
    Route::post("/deletar-eventos", "CalendarioController@delete");
    Route::post("/cronograma-detalhe", "CalendarioController@cronogramaDetalhe");

//Route for store tasks
    Route::post("/cadastra-tarefas", "TarefasController@store");
    Route::post("/cadastra-tarefas-cliente", "TarefasController@storeCliente");
    Route::get("/editar-tarefas?{id}", "TarefasController@editar");
    Route::get("/editar-tarefas-cliente?{id}", "TarefasController@editarTarefaCliente");
    Route::post("/editar-tarefas", "TarefasController@atualizar");
    Route::post("/editar-tarefas-cliente", "TarefasController@atualizarTarefaCliente");
    Route::get("/finalizar-tarefas/{id}", "TarefasController@finalizar");
    Route::post("/solicitar-prazo-tarefas", "TarefasController@solicitarPrazo");
    Route::post("/negar-prazo-tarefas", "TarefasController@negarPrazo");
    Route::post("/conceder-prazo-tarefas", "TarefasController@concederPrazo");
    Route::get("/deletar-tarefas/{id}", "TarefasController@delete");

    Route::post("/cadastrar-gastos", "GastosController@store");
    Route::post("/visualizar-gastos-mes", "GastosController@mostrar");
    Route::post("/visualizar-gastos-mes-busca", "GastosController@mostrarBusca");
    Route::post("/cadastrar-gastos", "GastosController@store");
    Route::post("/editar-gastos", "GastosController@edit");
    Route::post("/deletar-gastos", "GastosController@destroy");
    Route::post("/imprimir-gastos", "GastosController@imprimir");
    Route::post("/deletar-foto-gasto","GastosController@deletarFoto");



    Route::post("/cadastrar-relatorio", "RelatorioController@storeVisitaTecnica");
    Route::post("/editar-relatorio", "RelatorioController@edit");
    Route::post("/reenviar-emails-relatorio", "RelatorioController@reenviarEmails");
    Route::post("/atualizar-relatorio", "RelatorioController@update");
    Route::post("/relatorio-imprimir", "RelatorioController@imprimir");
    Route::post("/relatorio-visulaizar", "RelatorioController@visulaizar");
    Route::post("/deletar-foto-relatorio", "RelatorioController@deletarFotoRelatorio");

    Route::get("/alerta-deleta/{id}", "AlertaController@destroy");

    Route::get("/visualizar-relatorio-email", array(
        'as' => 'visualizar-relatorio-email',
        'uses' => 'RelatorioController@visualizarRelatorioEmail'
    ));


//start test
    Route::get("teste", function () {
        return "Rota de testes";
    });
//end test

});


//logout system
Route::get("/logout", "HomeController@makeLogout");



/**Rotas para WebServices Qualim-Android*/
Route::post("/login-android", "QualimAndroidController@loginAndroid");
Route::post("/logout-android", "QualimAndroidController@logoutAndroid");
Route::post("/store-expense-android", "QualimAndroidController@storeExpenseAndroid");
Route::post("/show-expense-android", "QualimAndroidController@showExpenseAndroid");
Route::post("/store-events-android", "QualimAndroidController@storeEventsAndroid");
Route::post("/show-events-android", "QualimAndroidController@showEventsAndroid");
Route::post("/store-photo-android", "QualimAndroidController@storePhoto");
Route::post("/show-photo-android", "QualimAndroidController@showPhoto");
Route::post("/store-signature-android", "QualimAndroidController@storeSignature");
Route::post("/change-password-android", "QualimAndroidController@changePassword");
Route::get("/relatorio-visita-tecnica-cad-android", "QualimAndroidController@relatorioVisitaTecnicaCad");
Route::post("/cadastrar-relatorio-android", "QualimAndroidController@storeVisitaTecnicaAndroid");

Route::get('phpinfo', function(){
   return phpinfo();
});

