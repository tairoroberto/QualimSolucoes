@extends('layout.layout')

  @section('head')
    @parent
    <script type="text/javascript">
    function enviar(id){
      formNutricionistaLista.nutricionista_id.value = id;
      formNutricionistaLista.submit();
    }
    </script>
  @stop
   
    @section('content')
          {{-- expr --}}
    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">
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
        <h3><span class="semi-bold">Cronograma do mês de {{$mesCorrente}}</span></h3>
      </div>
            <div class="span12">
              <div class="grid simple">
              {{Form::open(array('id'=>'formNutricionistaLista','url'=>'editar-usuario'))}}
                
              <input type="hidden" id="nutricionista_id" name="nutricionista_id">
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:25%">Consultora</th>
                        <th style="width:20%">Título</th>
                        <th style="width:21%">Descricão</th>
                        <th style="width:21%">Local</th>
                        <th style="width:15%">Início</th>
                        <th style="width:15%">Término</th>
                        
                      </tr>

                    </thead>
                    <tbody>   
                       @foreach ($cronogramas as $cronograma) 

                          <?php $nutricionista = Nutricionista::find($cronograma->nutricionista_id);?>

                          <?php $dataInicio = explode(" ", $cronograma->start) ?>
                          <?php $dataFim = explode(" ", $cronograma->end) ?>
                          <?php $horaIncio = $dataInicio[1]; ?>
                          <?php $horaFim = $dataFim[1]; ?>
                          <?php $dataInicio = explode("-", $dataInicio[0]) ?>
                          <?php $dataFim = explode("-", $dataFim[0]) ?>

                                <tr >
                                    <td class="v-align-middle">{{$nutricionista->name}}</td>
                                    <td class="v-align-middle">{{$cronograma->title}}</td>
                                    <td class="v-align-middle">{{$cronograma->description}}</td>
                                    <td class="v-align-middle">{{$cronograma->location}}</td>
                                    <td class="v-align-middle">{{$dataInicio[2]."/".$dataInicio[1]."/".$dataInicio[0]." ". $horaIncio}}</td>
                                    <td class="v-align-middle">{{$dataFim[2]."/".$dataFim[1]."/".$dataFim[0]." ". $horaFim}}</td>
                               </tr>
                        
                       @endforeach

                    </tbody>
                  </table>

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