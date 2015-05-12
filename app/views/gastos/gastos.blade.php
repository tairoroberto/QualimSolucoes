@extends('layout.layout')

@section('head')
  @parent
  <script type="text/javascript">
   jQuery(function(){
   $("#hora-entrada").mask("99:99:99");
   $("#hora-saida").mask("99:99:99");

    $("#vale-refeicao").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("#vale-transporte").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});
    $("#gasto-extra").maskMoney({prefix:'', allowNegative: true, thousands:'.', decimal:',', affixesStay: false});

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

       $('#myModal').modal('show');

       $("#situacao").val(situation);

   }


    function salvarDespesa() {
        if($("#situacao").val() == ""){
            formGastos.action = "{{action('GastosController@store')}}";
            formGastos.submit();
        }else{
            formGastos.action = "{{action('GastosController@edit')}}";
            formGastos.submit();
        }
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
                                           <a href="#">
                                               <i class="fa fa-paste"></i>
                                           </a>
                                     @else
                                           <a href="#">
                                               <i class="fa fa-edit"></i>
                                           </a>
                                     @endif

                                    </td>
                                    <td class="v-align-middle">{{$calendario->title}}</td>
                                    <td class="v-align-middle">{{$calendario->description}}</td>
                                    <td class="v-align-middle">{{$calendario->location}}</td>
                                    <td class="v-align-middle">{{$dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0]." ". $horaIncio}}</td>
                                    <td class="v-align-middle">{{$dataFim[2]."/".$dataFim[1]."/".$dataFim[0]." ". $horaFim}}</td>
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
                    <h4 class="modal-title">Insira os dados da despesa</h4>
                    </div>
                    <div class="modal-body" align="center">
                    {{--Start modal body--}}
                       <div class="row column-seperation">
                        <div class="col-md-12">

                         <div class="row form-row">


                          <div class="col-md-5">
                              <input name="cliente-local" id="cliente-local" type="text"  class="form-control" placeholder="Cliente/Local" value="{{Input::old('cliente-local')}}">
                          </div>

                          <div class="col-md-3">
                              <div id="datetimepicker1" class="input-append date">
                                  <input data-format="dd-MM-yyyy" type='text' id="date" name="date" class="form-control" placeholder="Data da visita"/>
                                        <span class="add-on">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                              </div>
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
                      <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                      <input type="hidden" id="situacao">
                      <button type="button" id="btnBuscarDados" class="btn btn-primary"  data-dismiss="modal" onclick="salvarDespesa();">Salva despesa</button>
                    </div>
                  </div><!-- /.modal-content -->
                </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->


                <div class="form-actions">
                  <div class="pull-left"></div>
                  <div class="pull-right">
                    <button class="btn btn-primary btn-cons" type="submit">Salvar </button>

                    <button class="btn btn-danger btn-cons" type="reset">Cancelar</button>
                  </div>
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
