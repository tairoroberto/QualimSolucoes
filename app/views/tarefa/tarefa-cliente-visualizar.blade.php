<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Qualim | Soluções</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />

<link href="packages/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="packages/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="packages/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="packages/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>
    <!-- END CORE CSS FRAMEWORK -->


<!-- BEGIN CSS TEMPLATE -->
<link href="packages/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>

<link href="packages/assets/plugins/boostrap-slider/css/slider.css" rel="stylesheet" type="text/css"/>
<script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery-mask/jquery.maskedinput.js"></script>
<script type="text/javascript" src="packages/assets/js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery-mask/jquery.mask.js"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="packages/assets/js/CriarComponentes.js"></script>
<script type="text/javascript" src="packages/assets/plugins/bootstrap-progressbar.js"></script>

<!-- END CSS TEMPLATE -->
</head>
<!-- END HEAD -->
<script type="text/javascript">

$(document).ready(function() {
  var bar = $('.progress-bar');
  $(function(){
    $(bar).each(function(){
      bar_width = $(this).attr('aria-valuenow');
      $(this).width(bar_width + '%');
    });
  });  
});


function tarefaPedirPrazo(id) {
  $("#tarefa_id").val(id);
}

function tarefaNegarPrazo(id){
  $("#tarefaNegarPrazo_id").val(id); 
  formNegarPrazo.submit();
}


function tarefaConcederPrazo(id){
  $("#tarefaPrazo_id").val(id); 
}


jQuery(function($){
    $("#dataPrazo").mask("99/99/9999");

    $('#datetimepicker1').datetimepicker({
        language: 'pt-BR'
    });

});

</script>



<!-- BEGIN BODY -->
<body class="">


@include('layout.sidebar')      
          
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"></div>
              <!-- START FORM -->

    <?php 
    //Função para conversão de datas
       function converteData($data){
          return (preg_match('/\//',$data)) ? implode('-', array_reverse(explode('/', $data))) : implode('/', array_reverse(explode('-', $data)));
         } 

     ?>


    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                {{ implode('', $errors->all('<li class="error">:message</li>')) }}
            </ul>
        </div>
    @endif
              
    <!-- START FORM -->          
     <div class="row">
       <div class="col-md-12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs" id="tab-01">


          {{-- Se não for o admin só verá as tarefas dele.--}}

            <?php $tarefas = Tarefa::where('cliente_id','=',Auth::cliente()->get()->id)
                                      ->where('SituacaoEtapaTarefa','!=','Finalizado')
                                      ->get();
                  $cont=0; 
              ?>
          
            

          {{--Se houver tarefas cadastrada mostra o nome do ususario logado--}}
          @if (count($tarefas) > 0)
            {{--Dono da tarefa--}}
                {{--<li style=" padding:15px;">{{Auth::user()->get()->name}}</li>--}}
          @endif

             
            @foreach ($tarefas as $tarefa)

               <?php 

                  $inicio = converteData($tarefa->date_start);
                  $fim = converteData($tarefa->date_finish); 

                  $Inicio = strtotime("$inicio");
                  $Entrega = strtotime("$fim");
                  $d =  strtotime(date('Y/m/d'));
 
                  $diasCor = $Entrega - $d;

                  $seg = 86400;

             ?>  
              <li class="<?php if($cont == 0){echo "active";} ?>">
                 <a href="#tabela{{$tarefa->id}}">
                  <i class="<?php
                          if(($tarefa->SituacaoEtapaTarefa != "Finalizado") && (($diasCor/$seg) >= 0)){
                            echo "fa fa-clock-o";
                            } else if(($diasCor/$seg) < 0){
                              echo "fa fa-warning";
                            } else if($tarefa->SituacaoEtapaTarefa == "Finalizado"){
                              echo "fa fa-check";
                            } ?>">
                    </i>


                     <?php
                        //Pega o nome do usuario da tarefa
                        $cliente = Cliente::find($tarefa->cliente_id);
                     ?>

                     {{--Printa o nome do usuario responsavél pela arefa--}}
                        {{$tarefa->title}}
                  </a>
              </li>
              <?php $cont++;0 ?>
            @endforeach
          </ul>
         
          
          <div class="tab-content">

          {{-- Se não for o admin só verá as tarefas dele.--}}

            <?php $tarefas2 = Tarefa::where('cliente_id','=',Auth::cliente()->get()->id)
                                      ->where('SituacaoEtapaTarefa','!=','Finalizado')
                                      ->get();
                  $cont2=0; 
              ?>

            @foreach ($tarefas2 as $tarefa2)

          <div class="tab-pane <?php if($cont2 == 0){echo "active";} ?>" id="tabela{{$tarefa2->id}}">
              <div class="row">
                <div class="col-md-12">
                  <!--INICIO DA AÇÂO-->
                    <div class=" col-md-4 btn-group"> <a class="btn btn-white dropdown-toggle btn-demo-space" data-toggle="dropdown" href="#"> Ações<span class="caret"></span> </a>
                          <ul class="dropdown-menu">
                            <li >
                              <a href="{{action('TarefasController@finalizar',$tarefa2->id)}}">
                                Finalizar
                              </a>
                            </li> 
                            {{--Ao clicar o Id da tarefa será setado no input hidden tarefa_id para 
                                ser enviado com  metodo post --}}
                            <li onclick="tarefaPedirPrazo({{$tarefa2->id}});">
                              <a data-toggle="modal" data-target="#modalTarefaPedir">
                                Solicitar prazo
                              </a>
                            </li>

                          </ul>
                      </div>
                  <!--FIM DA AÇÂO-->  
                          
                          {{-- Title of task--}}
                  <h3><span class="semi-bold">{{$tarefa2->title}}</span></h3>                    
                          {{-- Description of task--}}
                  <p class="light">Descrição: {{$tarefa2->description}}</p>

                  <?php $nutricionista = Nutricionista::find($tarefa2->nutricionista_id); ?>
                  <p class="light">Responsável: {{$nutricionista->name}}</p>
                  <br>
                  </div>

                  <!--Função para fazer a subtração da data retornada -->
                        <?php
                           
                            $data_inicio = converteData($tarefa2->date_start);
                            $data_fim = converteData($tarefa2->date_finish); 


                            $DataInicio = strtotime("$data_inicio");
                            $DataEntrega = strtotime("$data_fim");
                            $dataHoje =  strtotime(date('Y/m/d'));
 
                            $duracao = $DataEntrega - $DataInicio;
                            $diasAtraso = $dataHoje - $DataEntrega;   
                            $diasCorridos = $DataEntrega - $dataHoje;
                            $dias = $dataHoje - $DataInicio;

                            $segundos = 86400;
                          
                         if((($diasCorridos / $segundos) < 0) && 
                            ($tarefa2->SituacaoEtapaTarefa != 'Finalizar')) {
                            $porcetagem = 100;
                          }else{
                            if($duracao != 0){
                                $porcetagem = $dias * 100 / $duracao;
                            }else{
                                $porcetagem = $dias * 100;
                            }
                          }
                          
                          ?>
                  <div class="col-md-3">
                  <p class="light"><strong>Data Inicio:</strong> {{$tarefa2->date_start}}</p>
                  </div>
                  <div class="col-md-3">
                  <p class="light"><strong>Data Prevista:</strong> {{$tarefa2->date_finish}}</p>
                  </div>
                  <div class="col-md-3">
                  <p class="light"><strong>Duração Prevista:</strong> <?php echo $duracao / $segundos; ?> dias</p>
                  
                </div>                           
                  <div class="col-md-12"><br>

             <div class="progress progress-striped active progress-large">
          {{--Inicio barra de progresso--}}
            
            <?php //Verificação da data 
                if ((($diasCorridos / $segundos) < 0) && ($tarefa2->SituacaoEtapaTarefa != 'Finalizado')) {
                   echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar progress-bar-danger'>TAREFA COM ATRASO DE: ".$diasCorridos / $segundos." DIAS</div>";
                }elseif ((($diasCorridos / $segundos) < 0) && ($tarefa2->SituacaoEtapaTarefa != 'Finalizado')) {
                    echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar progress-bar-caution '>TAREFA FINALIZADA </div>";
                }elseif ((($diasCorridos / $segundos) > 0) && ($tarefa2->SituacaoEtapaTarefa != 'Finalizado')) {
                  echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar' >TAREFA COM ".$dias / $segundos." DIAS DE TRABAHO</div>";
                }elseif ((($diasCorridos / $segundos) > 0) && ($tarefa2->SituacaoEtapaTarefa == 'Finalizado')) {
                    echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar progress-bar-caution '>TAREFA FINALIZADA </div>";
                }elseif ((($diasCorridos / $segundos) == 0) && ($tarefa2->SituacaoEtapaTarefa != 'Finalizado')){
                    echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar progress-bar-caution '>TAREFA EM ANDAMENTO</div>";
                }elseif ((($diasCorridos / $segundos) == 0) && ($tarefa2->SituacaoEtapaTarefa == 'Finalizado')){
                    echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar animate-progress-bar'>TAREFA FINALIZADA </div>";
                }else{
                    echo "<div aria-valuemin='0' aria-valuenow='".$porcetagem."' class='progress-bar animate-progress-bar'>TAREFA FINALIZADA </div>";
                  }
                ?> 
          {{--Fim barra de progresso--}}     


           </div> 
           {{--Begin histórico--}} 
             <h4>Hisorico</h4>
             <?php $historicos = TarefaHistorico::where('tarefa_id','=',$tarefa2->id)->get(); ?>
              @foreach ($historicos as $historico)

                  <?php
                    $dataFull = explode(" ",$historico->updated_at);
                    $data = explode("-",$dataFull[0])
                  ?>

               
                @if ($historico->historico == "Solicitação de prazo negada")
                  <div class="well well-small danger">                  
                     <span style="color: red;">{{ $historico->historico ." : ".$data[2]."/".$data[1]."/".$data[0]." ".$dataFull[1]}}</span>
                  </div>
                                
                @elseif ($historico->historico == "Prazo concedido até : ".$tarefa2->date_finish)
                  <div class="well well-small danger">                  
                     <span style="color: blue;">{{ $historico->historico }}</span>{{" : ".$data[2]."/".$data[1]."/".$data[0]." ".$dataFull[1]}}
                  </div>

                 @elseif (strstr($historico->historico,"Prazo Solicitado"))
                  <div class="well well-small danger">                  
                     <span style="color: green;">{{ $historico->historico}}</span>{{" : ".$data[2]."/".$data[1]."/".$data[0]." ".$dataFull[1]}}
                  </div>

                @else
                   <div class="well well-small" >                  
                        {{ $historico->historico ." : ".$data[2]."/".$data[1]."/".$data[0]." ".$dataFull[1]}}
                   </div>
                @endif

               

              @endforeach 

            {{--End histórico--}}          
          </div> 
         </div>   
        </div>
       <?php $cont2++; ?> 

     @endforeach
               
               

       </div>
      </div>
     <br>
    </div>
   </div>
  </div>
 </div>
<a href="#" class="scrollup">Subir</a>

       <!-- Begin Modal -->
        <div class="modal fade" id="modalTarefaPedir" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          {{Form::open(array('id' => 'formModal','action' => 'TarefasController@solicitarPrazo'))}}
            <div class="modal-dialog">
              <div class="modal-content">
                <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                  <h4 class="modal-title" id="TarefaPedirLabel">Informe o motivo da solicitação</h4>
                    </div>

                    <div class="modal-body">
                      <div class="row">
                           <textarea rows="4" cols="50" name="motivoPrazo" placeholder="Informe o motivo..." style="width:100%">
                           </textarea>
                           <input type="hidden" name="tarefa_id" id="tarefa_id" >
                          <input type="hidden" name="pagina_cliente" id="pagina_cliente" value="1" >

                      </div>                                 
                    </div>

                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>                  
                   <button type="submit" class="btn btn-primary">Enviar</button>                  
                </div>
              </div>
            </div>
            {{Form::close()}}
          </div>



        <!-- Begin Modal -->
        {{Form::open(array('id' => 'formModalData','action' => 'TarefasController@concederPrazo'))}}
        <div class="modal fade" id="modalTarefaConceder" tabindex="-1" role="dialog" aria-labelledby="myModalDataLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Fechar</span></button>
                        <h4 class="modal-title" id="TarefaDataLabel">Informe a nova data de término</h4>
                    </div>

                    <div class="modal-body" align="center">
                        <label>Extender prazo até</label>
                        <input type="text" name="dataPrazo" id="dataPrazo" placeholder="10/10/2015" style="text-align:center">
                        <input type="hidden" name="tarefaPrazo_id" id="tarefaPrazo_id" >

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Enviar</button>
                    </div>
                </div>
            </div>
        </div>
        {{Form::close()}}

      <!-- End Modal -->
        {{Form::open(array('id' => 'formNegarPrazo','action' => 'TarefasController@negarPrazo'))}}
          <input type="hidden" name="tarefaNegarPrazo_id" id="tarefaNegarPrazo_id" >
        {{Form::close()}}

      <!--begin form-->
      <!--end form-->
   
  <!-- END SIDEBAR --> 
  <!-- BEGIN PAGE CONTAINER-->
  </div>
 </div>
<!-- END CONTAINER -->

<!-- END CONTAINER -->

<!-- BEGIN CORE JS FRAMEWORK-->
<script src="packages/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/boostrapv3/js/bootstrap.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/breakpoints.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
<script type="text/javascript" src="packages/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="packages/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<!-- END PAGE LEVEL PLUGINS -->
<!-- PAGE JS -->
<script src="packages/assets/js/tabs_accordian.js" type="text/javascript"></script>
<!-- BEGIN CORE TEMPLATE JS -->
<script src="packages/assets/js/core.js" type="text/javascript"></script>
<script src="packages/assets/js/chat.js" type="text/javascript"></script> 
<script src="packages/assets/js/demo.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
</body>
</html>