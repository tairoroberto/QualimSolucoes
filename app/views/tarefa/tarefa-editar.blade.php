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
          return 0;
     }

     if((formTarefas.SelectResponsavel1.value != "") && (formTarefas.TituloTarefa1.value == "")) {
     alert("Ttitulo da solicitação não informado...!!!");
     formTarefas.TituloTarefa1.focus();
         return 0;
     }

       if((formTarefas.SelectResponsavel1.value != "") &&
        (formTarefas.Descricaotarefa1.value == "")) {
     alert("Descrição da solicitação não informado...!!!");
     formTarefas.Descricaotarefa1.focus();
           return 0;
     }

     if((formTarefas.SelectResponsavel1.value != "") && 
        (formTarefas.DataEntregaTarefa1.value == "")) {
     alert("Data da entrega não informada...!!!");
     formTarefas.DataEntregaTarefa1.focus();
         return 0;
     }

     if(formTarefas.SelectResponsavel1.value == ""){
     alert("Selecione um reponsável...!!!");
     formTarefas.SelectResponsavel1.focus();
     return 0;
     }

    return 1;
}

  function enviar(){
      if(validaTarefa() == 1 && verificaTarefa() == 1){
          document.formTarefas.submit();
      }
  }

</script>
@stop



@section('content')


     
  <form name="formTarefas" id="formTarefas" method="POST" action="{{action('TarefasController@atualizar')}}">
          
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Editar - <span class="semi-bold">Tarefa</span></h3>
              </div>
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-24">
                  <div class="grid simple">
                    <div class="grid-body no-border">
                   
                     
                     <?php $data = date('d/m/Y');?>
                     <div class="row form-row" >
                        
                     </div>

                   <div class="row form-row">
                    <div class="col-md-10">
                     <h4>Tarefa </h4>
                    </div>

                    <div class="col-md-2" > 
                          <input name="DataInicio" id="DataInicio" type="text"  class="form-control" value="{{$data}}" readonly="true">
                        </div>
                    </div>
                    
                    <div class="row form-row">
                    <div class="col-md-2">
                        <select id="SelectResponsavel1" name="SelectResponsavel1" style="width:100%">
                        <?php $nutricionistas1 =  Nutricionista::withTrashed()->find($tarefa->nutricionista_id); ?>
                        <option value="{{$nutricionistas1->id}}">{{$nutricionistas1->name}}</option>
                   
                   <?php $nutricionistas2 =  Nutricionista::where('type','!=','Cliente')->get(); ?>
                       @foreach ($nutricionistas2 as $nutricionista2) 
                          <option value="{{$nutricionista2->id}}">{{$nutricionista2->name}}</option>'); 
                       @endforeach 
                  
                  </select>
                      </div>
                      
                      <div class="col-md-2">
                        <input name="TituloTarefa1" id="TituloTarefa1" type="text"  class="form-control" placeholder="Titulo " value="{{$tarefa->title}}">
                      </div>
                      <div class="col-md-6">
                        <input name="Descricaotarefa1" id="Descricaotarefa1" type="text"  class="form-control" placeholder="Descrição " value="{{$tarefa->description}}">
                      </div>
                      <div class="col-md-2">
                        <input name="DataEntregaTarefa1" id="DataEntregaTarefa1" type="text"  class="form-control" placeholder="Data entrega " value="{{$tarefa->date_finish}}">
                      </div>
                      
                    </div>
                    <input type="hidden" name="tarefa_id" id="tarefa_id" value="{{$tarefa->id}}">
                                        
              

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


                     function verificaTarefa() {
                                var etapa = document.getElementsByName('SelectUsuarioArray[]');
                                var titulo = document.getElementsByName('TituloArray[]');
                                var descricao = document.getElementsByName('DescricaoArray[]');
                                var data = document.getElementsByName('DataEntregaArray[]');
                                  for (var i in etapa){
                                    if (etapa[i].value == "Responsável" && titulo[i].value != "") {
                                      alert("Selecione um Responsável");
                                      etapa[i].focus();
                                        return 0;
                                    }     
                                  }

                                  for (var j in titulo){
                                    if (titulo[j].value == "" && etapa[j].value != "Responsável") {
                                      alert("Informe um Titulo para solicitação...");
                                      titulo[j].focus();
                                        return 0;
                                    }     
                                  } 

                                  for (var k in descricao){
                                    if (descricao[k].value == "" && etapa[k].value != "Responsável") {
                                      alert("Informe uma descrição para solicitação...");
                                      descricao[k].focus();
                                        return 0;
                                    }     
                                  } 

                                  for (var l in data){
                                    if (data[l].value == "" && etapa[l].value != "Responsável") {
                                      alert("Informe a data de entrega...");
                                      data[l].focus();
                                        return 0;
                                    }     
                                  }

                                return 1;
                               }
                                
                  </script>


                    
                     <div class="row form-row">
                    <div class="col-md-10">
                    <h4><label id="labelTotal"></label></h4>
                    </div>
                    <div class="col-md-2">
                   
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
                                    onclick="enviar();">Salvar </button>

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