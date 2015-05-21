@extends('layout.layout')


@section('head')
  @parent
    <script type="text/javascript">

  jQuery(function($){
       $("#DataInicio").mask("99/99/9999");
       $("#DataEntregaTarefa1").mask("99/99/9999");
  });

  function mascaraData(){
    $("input[id='DataEntregaArray[]']").mask("99/99/9999");
  }

  /*********************************************************************************************/
/*        Validação dos dados das TAREFAS se campos estiverem em branco gera alerta         */
/*                                                                                           */
/*********************************************************************************************/
function validaTarefa(){

    if((formTarefas.SelectResponsavel1.value == "") && (formTarefas.TituloTarefa1.value != "")){
        alert("Selecione um reponsável...!!!");
        formTarefas.SelectResponsavel1.focus();
        exit();
    }

    if((formTarefas.SelectResponsavel1.value != "") && (formTarefas.TituloTarefa1.value == "")) {
        alert("Ttitulo da solicitação não informado...!!!");
        formTarefas.TituloTarefa1.focus();
        exit();
    }


    if((formTarefas.SelectCliente1.value == "") && (formTarefas.TituloTarefa1.value != "")){
        alert("Selecione um Cliente...!!!");
        formTarefas.SelectCliente1.focus();
        exit();
    }

    if((formTarefas.SelectCliente1.value != "") && (formTarefas.TituloTarefa1.value == "")) {
        alert("Ttitulo da solicitação não informado...!!!");
        formTarefas.TituloTarefa1.focus();
        exit();
    }


    if((formTarefas.SelectResponsavel1.value != "") &&
        (formTarefas.Descricaotarefa1.value == "")) {
        alert("Descrição da solicitação não informado...!!!");
        formTarefas.Descricaotarefa1.focus();
        exit();
    }

    if((formTarefas.SelectResponsavel1.value != "") &&
        (formTarefas.DataEntregaTarefa1.value == "")) {
        alert("Data da entrega não informada...!!!");
        formTarefas.DataEntregaTarefa1.focus();
        exit();
    }

    if(formTarefas.SelectResponsavel1.value == ""){
        alert("Selecione um reponsável...!!!");
        formTarefas.SelectResponsavel1.focus();
        exit();
    }

    if(formTarefas.SelectCliente1.value == ""){
        alert("Selecione um Cliente...!!!");
        formTarefas.SelectCliente1.focus();
        exit();
    }

}


</script>
@stop



@section('content')


     
  <form name="formTarefas" id="formTarefas" method="POST" action="{{action('TarefasController@storeCliente')}}">
          
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Cadastro - <span class="semi-bold">Tarefas Cliente</span></h3>
              </div>
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-24">
                  <div class="grid simple">
                    <div class="grid-body no-border">

                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                                </ul>
                            </div>
                        @endif
                     
                     <?php $data = date('d/m/Y');?>
                     <div class="row form-row" >
                        
                     </div>

                   <div class="row form-row">
                    <div class="col-md-10">
                     <h4>Tarefa 1 </h4>
                    </div>

                    <div class="col-md-2" > 
                          <input name="DataInicio" id="DataInicio" type="text"  class="form-control" value="{{$data}}" readonly="true">
                        </div>
                    </div>
                    
                    <div class="row form-row">

                    <div class="col-md-2">
                        <select id="SelectResponsavel1" name="SelectResponsavel1" style="width:100%">
                            <option value="">Responsável</option>

                            <?php $nutricionistas =  Nutricionista::where('type','!=','Cliente')->get(); ?>
                            @foreach ($nutricionistas as $nutricionista)
                              <option value="{{$nutricionista->id}}">{{$nutricionista->name}}</option>');
                            @endforeach
                        </select>
                      </div>


                        <div class="col-md-2">
                            <select id="SelectCliente1" name="SelectCliente1" style="width:100%">
                                <option value="">Cliente</option>

                                <?php $clientes =  Cliente::all(); ?>
                                @foreach ($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->razaoSocial}}</option>');
                                @endforeach
                            </select>
                        </div>
                      
                      <div class="col-md-2">
                        <input name="TituloTarefa1" id="TituloTarefa1" type="text"  class="form-control" placeholder="Titulo ">
                      </div>
                      <div class="col-md-4">
                        <input name="Descricaotarefa1" id="Descricaotarefa1" type="text"  class="form-control" placeholder="Descrição ">
                      </div>
                      <div class="col-md-2">
                        <input name="DataEntregaTarefa1" id="DataEntregaTarefa1" type="text"  class="form-control" placeholder="Data entrega ">
                      </div>
                      
                    </div>
                    
                                        
              

                    <!--INICIO DO CLONE DE TAREFAS-->

  

                          <div name="DivTarefasOrigem" id="DivTarefasOrigem">

                          </div>

                          <div name="DivTarefasDestino" id="DivTarefasDestino" >

                          </div>
                    
                   <!--FIM DO CLONE DE TAREFAS-->

                          <script type="text/javascript">
                    function insereSelect() {
                     $('select[name="SelectUsuarioArray[]"]').children().remove();
                     $('select[name="SelectUsuarioArray[]"]').append('<option value="Responsável">Responsável</option>');
                           <?php                                  
                                $nutricionistas =  Nutricionista::all(); ?>
                                @foreach ($nutricionistas as $nutricionista) 

                                $('select[name="SelectUsuarioArray[]"]').append('<option value="{{$nutricionista->id}}">{{$nutricionista->name}}</option>'); 
                                  
                                @endforeach 
                     }


                    function insereSelectCliente() {
                        $('select[name="SelectClienteArray[]"]').children().remove();
                        $('select[name="SelectClienteArray[]"]').append('<option value="Cliente">Cliente</option>');
                        <?php
                             $clientes =  Cliente::all(); ?>
                        @foreach ($clientes as $cliente)

                        $('select[name="SelectClienteArray[]"]').append('<option value="{{$cliente->id}}">{{$cliente->razaoSocial}}</option>');

                        @endforeach
                    }



                    function verificaTarefa() {
                        var etapa = document.getElementsByName('SelectUsuarioArray[]');
                        var cliente = document.getElementsByName('SelectClienteArray[]');
                        var titulo = document.getElementsByName('TituloArray[]');
                        var descricao = document.getElementsByName('DescricaoArray[]');
                        var data = document.getElementsByName('DataEntregaArray[]');


                        for (var i in etapa){
                            if (etapa[i].value == "Responsável" && titulo[i].value != "") {
                                alert("Selecione um Responsável");
                                etapa[i].focus();
                                exit();
                            }
                        }

                        for (var j in titulo){
                            if (titulo[j].value == "" && etapa[j].value != "Responsável") {
                                alert("Informe um Titulo para solicitação...");
                                titulo[j].focus();
                                exit();
                            }
                        }

                        for (var k in descricao){
                            if (descricao[k].value == "" && etapa[k].value != "Responsável") {
                                alert("Informe uma descrição para solicitação...");
                                descricao[k].focus();
                                exit();
                            }
                        }

                        for (var l in data){
                            if (data[l].value == "" && etapa[l].value != "Responsável") {
                                alert("Informe a data de entrega...");
                                data[l].focus();
                                exit();
                            }
                        }

                        for (var m in cliente){
                            if (cliente[m].value == "Cliente" && titulo[m].value != "") {
                                alert("Selecione um Cliente");
                                cliente[m].focus();
                                exit();
                            }
                        }
                    }
                                
                  </script>


                    
                     <div class="row form-row">
                    <div class="col-md-10">
                    <h4><label id="labelTotal"></label></h4>
                    </div>
                    <div class="col-md-2">
                     <button class="btn btn-primary btn-cons" id="btnAdicionar" type="button" onclick="criarCampoTarefaCliente();insereSelect();insereSelectCliente();mascaraData();">Adicionar tarefa </button>
                    </div>
                    </div>
                    
                   </div>
                          
                        </div>
                                               
                            </div>
                          </div>
                                             
                      </div>
                      <div class="form-actions">
                        <div class="pull-left"></div>
                        <div class="pull-right">
                           <button class="btn btn-primary btn-cons" type="button"
                                    onclick="validaTarefa();verificaTarefa();document.formTarefas.submit();">Salvar </button>
                          
                          <button class="btn btn-danger btn-cons" type="reset">Cancelar</button>
                        </div>
                      </div>
                    </form>



<script type="text/javascript">
  $(document).ready(function () {         
    
    $('#DataEntregaTarefa1').datepicker({
            format: "dd/mm/yyyy"
        }); 

  });

  $('#btnAdicionar').click(function(){

     $('.date').datepicker({ format: "dd/mm/yyyy" });
                       
  });

</script>



@stop