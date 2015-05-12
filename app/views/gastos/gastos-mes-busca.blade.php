@extends('layout.layout')


@section('content')
          {{-- expr --}}
    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">

   {{Form::open(array('url' => '/visualizar-gastos-mes-busca','method' => 'post','id' =>'formUsuarioLista'))}}
          
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
      </div>


          @if (Auth::user()->get()->type == "Administrador")
            
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
                    </div> 
                  <br>                     
                </div>
              </div>
          @endif


    <input type="hidden" name="nutricionista_id" id="nutricionista_id" value="{{$nutricionista_id}}">



            <div class="span12">
              <div class="grid simple">              
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:20%">Cliente</th>
                        <th style="width:7%">Data</th>                        
                        <th style="width:10%">Entrada</th>
                        <th style="width:8%">Saída</th>
                        <th style="width:10%">Refeição</th>
                         <th style="width:15%">Descrição vt</th>
                        <th style="width:10%">Transporte</th>
                        <th style="width:15%">Descrição</th>
                        <th style="width:10%">Gasto extra</th>                         
                      </tr>

                    </thead>
                    <tbody>  
                    <?php $vr = 0; $vrAux; $vt = 0; $vtAux; $gastoExtra = 0; ?> 
                       @foreach ($gastos as $gasto)    
                          <tr >
                           <?php $data = explode(" ", $gasto->date) ?>
                           <?php $data = explode("-", $data[0]) ?>



                              <td class="v-align-middle">{{$gasto->client_locale}}</td>
                              <td class="v-align-middle">{{$data[2]."/".$data[1]."/".$data[0]}}</td>
                              <td class="v-align-middle">{{$gasto->entry_time}}</td>
                              <td class="v-align-middle">{{$gasto->departure_time}}</td>
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
                  <b>Total de vale refeição:</b> {{number_format($vr, 2, ',', '.')}}   
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Total de vale transporte:</b> {{number_format($vt, 2, ',', '.')}}
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <b>Total de gastos extras:</b> {{number_format($gastoExtra, 2, ',', '.')}}
                  </div>
                </div>
              </div>



            {{Form::close()}}
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>
 @stop    