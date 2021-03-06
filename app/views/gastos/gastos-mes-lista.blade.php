@extends('layout.layout')

    @section('head')
        <script>
            function imprimir(){
                formGastos.action = "{{action('GastosController@imprimir')}}";
                formGastos.submit();
            }

            function modalImagens(fotos) {
                var div = '';
                fotos = fotos.split(',');
                for(var i=0;i<fotos.length;i++) {
                    if(fotos[i] != ',' && fotos[i] != null && fotos[i] != ""){
                        var foto = fotos[i].split("#");
                        div +=  "<div class='row form-row'>" +
                                "<div class='col-md-12'>" +
                                "<img src='" + foto[1]+ "' class='img-responsive' alt='Image' style='width: 400px;height: 400px'>" +
                                "<button class='btn btn-danger' onclick='deletarFoto("+foto[0]+")'>Deletar</button>"+
                                "</div>" +
                                "</div><br><br>";
                    }
                }

                $('#bodyFotos').html(div);

                $('#myModal').modal('show');

            }

            function deletarFoto(id){
                $("#id_foto").val(id);
                formGastos.action = "{{action('GastosController@deletarFoto')}}";
                formGastos.submit();
            }
        </script>
    @stop


    @section('content')
          {{-- expr --}}
    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">

   {{Form::open(array('url' => '/visualizar-gastos-mes-busca','method' => 'post','id' =>'formGastos'))}}



   {{--calculo do mes--}}
 <?php $mes = date('m');

   if ($mes == 1) {$mesCorrente = "Janeiro";}else
   if ($mes == 2) {$mesCorrente = "Fevereiro";}else
   if ($mes == 3) {$mesCorrente = "Março";}else
   if ($mes == 4) {$mesCorrente = "Abril";}else
   if ($mes == 5) {$mesCorrente = "Maio";}else
   if ($mes == 6) {$mesCorrente = "Junho";}else
   if ($mes == 7) {$mesCorrente = "Julho";}else
   if ($mes == 8) {$mesCorrente = "Agosto";}else
   if ($mes == 9) {$mesCorrente = "Setembro";}else
   if ($mes == 10) {$mesCorrente = "Outubro";}else
   if ($mes == 11) {$mesCorrente = "Novembro";}else
   if ($mes == 12) {$mesCorrente = "Dezenbro";}
 ?>
 {{--Fim do calculo--}}


          <div class="page-title"> 
        <h3>Lista de <span class="semi-bold">Despesas</span></h3>
              <br>
              <?php $nutricionista = Nutricionista::withTrashed()->find($nutricionista_id)?>
              <h4><span class="semi-bold">{{$nutricionista->name}}</span></h4>
      </div>





              <div class="grid simple">              
                <div class="grid-body">

                     <div class="col-md-3">
                      <select name="SelectMes" id="SelectMes" class="form-control" required="required">
                          <option value="{{$mes}}">{{$mesCorrente}}</option>
                            <option value="1">Janeiro</option>                          
                            <option value="2">Fevereiro</option>
                            <option value="3">Março</option>
                            <option value="4">Abril</option>
                            <option value="5">Maio</option>
                            <option value="6">Junho</option>
                            <option value="7">Julho</option>
                            <option value="8">Agosto</option>
                            <option value="9">Setembro</option>
                            <option value="10">Outubro</option>
                            <option value="11">Novembro</option>
                            <option value="12">Dezenbro</option>
                          </select>
                       </div> 

                   <div class="col-md-2">
                      <select name="SelectAno" id="SelectAno" class="form-control" required="required">
                         <option value="{{date('Y')}}">{{date('Y')}}</option>       
                         <option value="2015">2015</option>
                         <option value="2016">2016</option>
                         <option value="2017">2017</option>
                         <option value="2018">2018</option>
                         <option value="2019">2019</option>
                         <option value="2020">2020</option>                       
                       </select>
                    </div> 

                    <div class="col-md-3">
                      <button type="submit" class="btn btn-default">Buscar</button>
                      <button type="button" class="btn btn-success" onclick="imprimir()">Imprimir</button>
                    </div> 
                  <br>                     
                </div>
              </div>


              <input type="hidden" name="nutricionista_id" id="nutricionista_id" value="{{$nutricionista_id}}">

             <div class="grid simple">              
                <div class="grid-body" align="center">
                    <?php $nutricionista = Nutricionista::find($nutricionista_id); ?>
               {{"Relatório de despesas de ".$nutricionista->name." ".$mesCorrente." ".date('Y')}}
                </div>
             </div>

            <div class="span12">
              <div class="grid simple">              
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:1%"></th>
                        <th style="width:20%">Cliente</th>
                        <th style="width:7%">Data</th>                        
                        <th style="width:10%">Entrada</th>
                        <th style="width:8%">Saída</th>
                        <th style="width:4%">Horas</th>
                        <th style="width:10%">Refeição</th>
                         <th style="width:15%">Descrição vt</th>
                        <th style="width:10%">Transporte</th>
                        <th style="width:15%">Descrição</th>
                        <th style="width:10%">Gasto extra</th>                        
                      </tr>

                    </thead>
                    <tbody>   
                    <?php $vr = 0; $vrAux; $vt = 0; $vtAux; $gastoExtra = 0; $horas = 0; $minutos = 0; $segundos = 0;?>
                       @foreach ($gastos as $gasto)    
                          <tr >
                           <?php $data = explode(" ", $gasto->date) ?>
                           <?php $data = explode("-", $data[0]) ?>


                              <?php
                                  $first_date = new DateTime($gasto->entry_time);
                                  $second_date = new DateTime($gasto->departure_time);
                                  $difference = $first_date->diff($second_date);
                                  $horas += $difference->h;
                                  $minutos += $difference->i;
                                  $segundos += $difference->s;

                                  if($minutos >= 59){
                                      $horas += 1;
                                      $minutos -= 59;
                                  }

                                  if($segundos >= 59){
                                      $minutos += 1;
                                      $segundos -= 59;
                                  }

                              $imagens = ImagemGasto::where('id_gasto', '=', $gasto->id)->get();
                              $paths = "";

                              foreach ($imagens as $imagem) {
                                  $paths .= $imagem->id . "#" . $imagem->path . ",";
                              }

                              ?>



                               <td onclick="modalImagens('{{$paths}}')">
                                   <a href="#" title="Ver imagens">
                                       <i class="fa fa-instagram">
                                       </i>
                                   </a>
                               </td>

                              <td class="v-align-middle">{{$gasto->client_locale}}</td>
                              <td class="v-align-middle">{{$data[2]."/".$data[1]."/".$data[0]}}</td>
                              <td class="v-align-middle">{{$gasto->entry_time}}</td>
                              <td class="v-align-middle">{{$gasto->departure_time}}</td>
                              <td class="v-align-middle">{{$difference->format("%h:%i:%s")}}</td>
                              <td class="v-align-middle">{{$gasto->meal_voucher}}</td>
                              <td class="v-align-middle">{{$gasto->observation_transport}}</td>
                              <td class="v-align-middle">{{$gasto->transport_voucher}}</td>
                              <td class="v-align-middle">{{$gasto->observation_extra_expense}}</td>
                              <td class="v-align-middle">{{$gasto->extra_expense}}</td>
                           </tr>

                          <?php 
                           //soma so VR
                           $vrAux = str_replace("." , '' , $gasto->meal_voucher);  
                           $vrAux = str_replace("," , '.' , $vrAux ); 
                           $vr += $vrAux;

                           //soma so VT 
                           $vtAux = str_replace("." , '' , $gasto->transport_voucher);  
                           $vtAux = str_replace("," , '.' , $vtAux ); 
                           $vt += $vtAux;

                           //soma so Gasto Extra 
                           $gastoAux = str_replace("." , '' , $gasto->extra_expense);  
                           $gastoAux = str_replace("," , '.' , $gastoAux ); 
                           $gastoExtra += $gastoAux;

                           ?>
                         @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>


              <div class="span12">
                <div class="grid simple">              
                  <div class="grid-body" align="center">
                  <b>Vale refeição:</b> {{number_format($vr, 2, ',', '.')}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Vale transporte:</b> {{number_format($vt, 2, ',', '.')}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Gastos extras:</b> {{number_format($gastoExtra, 2, ',', '.')}}
                    &nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Total de horas:</b> {{ $horas.":".$minutos.":".$segundos }}
                  </div>
                </div>
              </div>



              <div class="modal modal-wide fade" id="myModal">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                          aria-hidden="true">&times;</span></button>
                          </div>

                          <div class="alert" style="display: none;" id="divErro">
                              <span class="label label-danger" id="msgErro"></span>
                          </div>

                          <div class="modal-body" align="center">
                              {{--Start modal body--}}
                              <div class="row column-seperation">
                                  <div class="col-md-12" id="bodyFotos">



                                  </div>
                              </div>
                              {{--End modal body--}}
                          </div>
                          <div class="modal-footer">

                              <input type="hidden" id="id_foto" name="id_foto">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                          </div>
                      </div>
                      <!-- /.modal-content -->
                  </div>
                  <!-- /.modal-dialog -->
              </div>
              <!-- /.modal -->


           {{Form::close()}}
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>
 @stop    