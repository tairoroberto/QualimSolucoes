@extends('layout.layout')

@section('head')
  @parent
  <script type="text/javascript">
   jQuery(function(){
   $("#hora-entrada").mask("99:99:99");
   $("#hora-saida").mask("99:99:99");

    $("#vale-refeicao").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("#vale-transporte").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("#gasto-extra").maskMoney({prefix:'R$ ', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

   });


   $(document).ready(function(){
    $('input[type=file]').bootstrapFileInput();
   });

   function chamaModal(calendario_id,location,date,start,end,situation){

       $('#vale-refeicao').val("");
       $('#observacaoValeTransporte').val("");
       $('#vale-transporte').val("");
       $('#observacaoGastoExtra').val("");
       $('#gasto-extra').val("");

       $('#gasto_id').val("");
       $('#nutricionista_id').val("");

       $('#calendario_id').val(calendario_id);
       $('#cliente-local').val(location);

       var dataFull = [];
       var data = [];

       dataFull = date.split(" ");
       data = dataFull[0].split("-");

       $('#date').val(data[2]+"-"+data[1]+"-"+data[0]);

       $('#hora-entrada').val(start);
       $('#hora-saida').val(end);

       $("#labelModal").html("Insira os dados da despesa para cadastro!");

       $('#myModal').modal('show');
       $("#situacao").val(situation);

    }

   function chamaModalEditar(gasto_id, calendario_id, client_locale, date, entry_time,
                             departure_time, meal_voucher,
                             observation_transport, transport_voucher,
                             observation_extra_expense, extra_expense,
                             nutricionista_id,situation){


       $('#cliente-local').val(client_locale);

       var dataFull = [];
       var data = [];

       dataFull = date.split(" ");
       data = dataFull[0].split("-");

       $('#date').val(data[2]+"-"+data[1]+"-"+data[0]);

       $('#hora-entrada').val(entry_time);
       $('#hora-saida').val(departure_time);
       $('#vale-refeicao').val(meal_voucher);
       $('#observacaoValeTransporte').val(observation_transport);
       $('#vale-transporte').val(transport_voucher);
       $('#observacaoGastoExtra').val(observation_extra_expense);
       $('#gasto-extra').val(extra_expense);
       $('#calendario_id').val(calendario_id);
       $('#gasto_id').val(gasto_id);
       $('#nutricionista_id').val(nutricionista_id);

       $("#labelModal").html("Insira os dados da despesa para edição!");

       $('#myModal').modal('show');

       $("#situacao").val(situation);

   }


    function salvarDespesa() {
        if($("#situacao").val() == ""){

            if(calculaData() != 0){
                formGastos.action = "{{action('GastosController@store')}}";
                formGastos.submit();
            }else{
                erro("O horário de entrada não pode ser menor que o de saída!");
                return;
            }

        }else{

            if(calculaData() != 0){
                formGastos.action = "{{action('GastosController@edit')}}";
                formGastos.submit();
            }else{
                erro("O horário de entrada não pode ser menor que o de saída!");
                return;
            }
        }
      return;
    }



   function erro(msg){
       $("#divErro").css("display","block");
       $("#msgErro").html(msg);
       return;
   }



    function verificaGastos(){
      /**busca a quantidade de tickets já cadastradas no banco */
      var quantCadastrada = "{{Gasto::where('nutricionista_id','=',Auth::user()->get()->id)
                                  ->where('meal_voucher','!=',"")
                                  ->count();}}";
      var quantPermitidas = "{{ Auth::user()->get()->num_ticket;}}";

      /**Verifica se a quantidade cadastrada no banco já foi ultrapassada*/
      if (quantCadastrada >= quantPermitidas) {
        alert("Você ultrapassou a quantidade de vales pemitida");
        $('#vale-refeicao').val("");
      }
   }


   $(function() {
       $('#datetimepicker1').datetimepicker({
           language: 'pt-BR'
       });

       $("#date").mask("99-99-9999");
   });


   function calculaData() {
       horaInicial = $("#hora-entrada").val();
       horaFinal = $("#hora-saida").val();

       // Tratamento se a hora inicial é menor que a final
       if( ! isHoraInicialMenorHoraFinal(horaInicial, horaFinal) ){
           // aux = horaFinal;
           //horaFinal = horaInicial;
           // horaInicial = aux;
           // alert("hora de término deve ser maior que hora de inicio");

           //$("#horaFim").focus();
           return 0;
       }

       hIni = horaInicial.split(':');
       hFim = horaFinal.split(':');

       horasTotal = parseInt(hFim[0], 10) - parseInt(hIni[0], 10);
       minutosTotal = parseInt(hFim[1], 10) - parseInt(hIni[1], 10);

       if(minutosTotal < 0){
           minutosTotal += 60;
           horasTotal -= 1;
       }

       horaFinal = horasTotal + ":" + minutosTotal;

       return 1;
   }

   /**
    * Verifica se a hora inicial é menor que a final.
    */
   function isHoraInicialMenorHoraFinal(horaInicial, horaFinal){
       horaIni = horaInicial.split(':');
       horaFim = horaFinal.split(':');

       // Verifica as horas. Se forem diferentes, é só ver se a inicial
       // é menor que a final.
       hIni = parseInt(horaIni[0], 10);
       hFim = parseInt(horaFim[0], 10);
       if(hIni != hFim)
           return hIni < hFim;

       // Se as horas são iguais, verifica os minutos então.
       mIni = parseInt(horaIni[1], 10);
       mFim = parseInt(horaFim[1], 10);
       if(mIni != mFim)
           return mIni < mFim;
   }

   /**
    * Soma duas horas.
    * Exemplo:  12:35 + 07:20 = 19:55.
    */
   function somaHora(horaInicio, horaSomada) {

       horaIni = horaInicio.split(':');
       horaSom = horaSomada.split(':');

       horasTotal = parseInt(horaIni[0], 10) + parseInt(horaSom[0], 10);
       minutosTotal = parseInt(horaIni[1], 10) + parseInt(horaSom[1], 10);

       if(minutosTotal >= 60){
           minutosTotal -= 60;
           horasTotal += 1;
       }

       horaFinal = horasTotal + ":" + minutosTotal;
       return horaFinal;
   }


      function mostraAlerta(){
          $('#myModal').modal('hide');

          $( "#dialog" ).dialog({
              modal: true,
              buttons: {
                  Sair: function() {
                      $( this ).dialog( "close" );
                  },

                  Deletar: function() {
                      if($("#situacao").val() != null){
                          formGastos.action = "{{action('GastosController@destroy')}}";
                          formGastos.submit();
                      }

                      $( this ).dialog( "close" );
                  }
              }
          });
      }

  </script>

  <style type="text/css">
    .modal.modal-wide .modal-dialog {
      width: 70%;
    }
  </style>
@stop

@section('content')
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Cadastro - <span class="semi-bold">Despesas</span></h3>
              </div>
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-24">

                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                        </ul>
                  </div>
                @endif
                

          <div class="grid simple">
        
            <div class="grid-body no-border">
            {{Form::open(array('id' =>'formGastos','action' => 'GastosController@store', 'files' => 'true'))}}
                   
           <div class="span12">
            <div class="grid simple">
              <input type="hidden" id="nutricionista_id" name="nutricionista_id">
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:1%">Ação</th>
                        <th style="width:20%">Título</th>
                        <th style="width:20%">Descricão</th>
                        <th style="width:20%">Cliente/Local</th>
                        <th style="width:15%">Inicio</th>
                        <th style="width:15%">Término</th>
                        <th style="width:10%">Situação</th>                        
                      </tr>

                    </thead>
                    <tbody> 
                    <?php
                    $mesInicio = date('Y-m')."-01";
                    $mesFim = date('Y-m')."-31";

                    $calendarios = Calendario::where('nutricionista_id','=',Auth::user()->get()->id)
                                             ->where('start','>=',$mesInicio)
                                             ->where('start','<=',$mesFim)
                                             ->get();?>  

                       @foreach ($calendarios as $calendario)
                       <?php $horaStart = explode(" ", $calendario->start) ?>
                       <?php $horaEnd = explode(" ", $calendario->end) ?>

                       <?php $dataInicio = explode(" ", $calendario->start) ?>
                       <?php $dataFim = explode(" ", $calendario->end) ?>
                       <?php $horaIncio = $dataInicio[1]; ?>
                       <?php $horaFim = $dataFim[1]; ?>
                       <?php $dataInicio = explode("-", $dataInicio[0]) ?>
                       <?php $dataFim = explode("-", $dataFim[0]) ?>

                                <tr >
                                   <td
                                      <?php if ($calendario->situation == ""){ ?>
                                      onclick="chamaModal('{{$calendario->id}}','{{$calendario->location}}','{{$calendario->start}}','{{$horaStart[1]}}','{{$horaEnd[1]}}','{{$calendario->situation}}');"
                                      <?php }else{?>

                                            <?php $gasto = Gasto::where("calendario_id", "=", $calendario->id)->get()->first();?>

                                            onclick="chamaModalEditar('{{$gasto->id}}','{{$calendario->id}}','{{$gasto->client_locale}}','{{$gasto->date}}','{{$gasto->entry_time}}','{{$gasto->departure_time}}','{{$gasto->meal_voucher}}','{{$gasto->observation_transport}}','{{$gasto->transport_voucher}}','{{$gasto->observation_extra_expense}}','{{$gasto->extra_expense}}','{{$gasto->nutricionista_id}}','{{$calendario->situation}}');"
                                      <?php } ?> >

                                     @if($calendario->situation == "")
                                           <a href="#" title="Cadastrar nova despesa">
                                               <i class="fa fa-paste"></i>
                                           </a>
                                     @else
                                           <a href="#" title="Editar despesa">
                                               <i class="fa fa-edit"></i>
                                           </a>
                                     @endif

                                    </td>
                                    <td class="v-align-middle">{{$calendario->title}}</td>
                                    <td class="v-align-middle">{{$calendario->description}}</td>
                                    <td class="v-align-middle">{{$calendario->location}}</td>

                                    {{--Verifica se o gasto já foi cadastrado
                                     se não foi mostra a data do calendario
                                     se foi cadastrado mostra a data do cadastro--}}
                                    @if($calendario->situation == "")
                                        <td class="v-align-middle">{{$dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0]." ". $horaIncio}}</td>
                                    @else
                                        {{--Mostra a data do cadastro do gasto--}}
                                        <?php $data1 = explode(" ", $gasto->date) ?>
                                        <?php $data2 = explode("-", $data1[0]) ?>
                                        <td class="v-align-middle">{{$data2[2]."/".$data2[1]."/".$data2[0]." ".$gasto->entry_time}}</td>
                                    @endif

                                    {{--Verifica se o gasto já foi cadastrado
                                     se não foi mostra a data do calendario
                                     se foi cadastrado mostra a data do cadastro--}}
                                    @if($calendario->situation == "")
                                        <td class="v-align-middle">{{$dataFim[2]."/".$dataFim[1]."/".$dataFim[0]." ". $horaFim}}</td>
                                    @else
                                        {{--Mostra a data do cadastro do gasto--}}
                                        <?php $data3 = explode(" ", $gasto->date) ?>
                                        <?php $data4 = explode("-", $data3[0]) ?>
                                        <td class="v-align-middle">{{$data4[2]."/".$data4[1]."/".$data4[0]." ".$gasto->departure_time}}</td>
                                    @endif


                                    <td class="v-align-middle">{{$calendario->situation}}</td>
                               </tr>
                        
                       @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>



             <div class="modal modal-wide fade" id="myModal">
              <div class="modal-dialog">
                <div class="modal-content">
                  <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><label class="alert" id="labelModal">Insira os dados da despesa</label></h4>
                    </div>

                    <div class="alert" style="display: none;" id="divErro">
                        <span class="label label-danger" id="msgErro"></span>
                    </div>

                    <div class="modal-body" align="center">
                    {{--Start modal body--}}
                       <div class="row column-seperation">
                        <div class="col-md-12">

                         <div class="row form-row">


                         <div id="datetimepicker1" class="col-md-3 input-append date ">
                             <input data-format="dd-MM-yyyy" type='text' id="date" name="date" class="form-control" placeholder="Data da visita"/>
                                <span class="add-on">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                         </div>

                         <div class="col-md-5">
                             <input name="cliente-local" id="cliente-local" type="text"  class="form-control" placeholder="Cliente/Local" value="{{Input::old('cliente-local')}}">
                         </div>

                          <div class="col-md-2">
                            <input name="hora-entrada" id="hora-entrada" type="text"  class="form-control" placeholder="Hora de entrada" value="{{Input::old('hora-entrada')}}">
                          </div>

                          <div class="col-md-2">
                            <input name="hora-saida" id="hora-saida" type="text"  class="form-control" placeholder="Hora de saída" value="{{Input::old('hora-saida')}}">
                          </div>

                        </div>


                        <div class="row form-row">

                          <div class="col-md-3">
                            <input name="vale-refeicao" id="vale-refeicao" type="text"  class="form-control" placeholder="Vale refeição " value="{{Input::old('vale-refeicao')}}" onblur=" verificaGastos();">
                          </div>
                          <div class="col-md-6">
                            <input name="observacaoValeTransporte" id="observacaoValeTransporte" type="text"  class="form-control" placeholder="Descrição vale transporte: ônibus + metrô + ônibus" value="{{Input::old('observacaoValeTransporte')}}">
                          </div>
                          <div class="col-md-3">
                            <input name="vale-transporte" id="vale-transporte" type="text"  class="form-control" placeholder="Soma do vale transporte " value="{{Input::old('vale-transporte')}}">
                          </div>
                          <div class="col-md-9">
                            <input name="observacaoGastoExtra" id="observacaoGastoExtra" type="text"  class="form-control" placeholder="Descrição dos gastos extras" value="{{Input::old('observacaoGastoExtra')}}">
                          </div>
                          <div class="col-md-3">
                            <input name="gasto-extra" id="gasto-extra" type="text"  class="form-control" placeholder="Valor dos Gastos extras" value="{{Input::old('gasto-extra')}}">
                          </div>


                            <input name="calendario_id" id="calendario_id" type="hidden" value="{{Input::old('calendario_id')}}">
                            <input type="hidden" name="nutricionista_id" id="nutricionista_id" value="{{Auth::user()->get()->id}}">
                            <input type="hidden" name="gasto_id" id="gasto_id" value="{{Input::old('gasto_id')}}" >

                        </div>
                      </div>
                    </div>
                    {{--End modal body--}}
                    </div>
                    <div class="modal-footer">

                      <input type="hidden" id="situacao">
                      <button type="button" id="btnBuscarDados" class="btn btn-primary" onclick="salvarDespesa();">Salva despesa</button>
                      <button type="button" id="btnBuscarDados" class="btn btn-danger" onclick="mostraAlerta();">Deletar despesa</button>
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->


                <div class="form-actions">
                  <div class="pull-left"></div>
                  <div class="pull-right">
                  </div>
                </div>

                {{--Diaolog--}}
                <div id="dialog" title="Cuidado" style="display: none">
                    <p>Esta ação irá apagar os dados da visita ao cliente e as despesas vinculadas a esta visita!"</p>
                </div>

            {{Form::close()}}
            </div>
          </div>
        </div>
      </div>
      <!-- END FORM -->
    </div>
  </div>
</div>
</div>
  </div>
  </div>
  <a href="#" class="scrollup">Subir</a>
   
  <!-- END SIDEBAR --> 
  <!-- BEGIN PAGE CONTAINER-->
  </div>

   @stop   
