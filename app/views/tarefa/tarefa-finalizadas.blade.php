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
<!-- END CORE CSS FRAMEWORK -->


<script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="packages/assets/plugins/bootstrap-progressbar.js"></script>
<!-- BEGIN CSS TEMPLATE -->
<link href="packages/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
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
              
             
              
    <!-- START FORM -->          
     <div class="row">
       <div class="col-md-12">
        <div class="tabbable tabs-left">
          <ul class="nav nav-tabs" id="tab-01">

          {{--Se o usuario logado for o admin, então ele poderá ver todas as tarefas --}}
          {{-- Se não for o admin só verá as tarefas dele.--}}

          @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Supervisora"))
            <?php $tarefas = Tarefa::where('SituacaoEtapaTarefa','=','Finalizado')
                                      ->get();
                  $cont=0; 
              ?>
          @else
            <?php $tarefas = Tarefa::where('nutricionista_id','=',Auth::user()->get()->id)
                                      ->where('SituacaoEtapaTarefa','=','Finalizado')
                                      ->get();
                  $cont=0; 
              ?>
          @endif



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
              <li class="<?php if($cont == 0){echo "active";} ?>" onclick="barra()";>
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
                     $user = Nutricionista::find($tarefa->nutricionista_id);
                     $firstName = explode(' ', $user->name) ?>

                     {{--Printa o nome do usuario responsavél pela arefa--}}
                     {{$firstName[0]." - ". $tarefa->title}}
                  </a>
              </li>
              <?php $cont++;0 ?>
            @endforeach
          </ul>
         
          
          <div class="tab-content">
          
          {{--Se o usuario logado for o admin, então ele poderá ver todas as tarefas --}}
          {{-- Se não for o admin só verá as tarefas dele.--}}
          
          @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Supervisora"))
            <?php $tarefas2 = Tarefa::where('SituacaoEtapaTarefa','=','Finalizado')
                                      ->get();
                  $cont2=0; 
              ?>
          @else
            <?php $tarefas2 = Tarefa::where('nutricionista_id','=',Auth::user()->get()->id)
                                      ->where('SituacaoEtapaTarefa','=','Finalizado')
                                      ->get();
                  $cont2=0; 
              ?>
          @endif

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

                            <?php if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Supervisora")) {?>
                              <li>
                                <a href="{{action('TarefasController@editar',$tarefa2->id)}}">
                                  Editar
                                </a>
                              </li>  

                              <li>
                                <a href="{{action('TarefasController@delete',$tarefa2->id)}}">
                                  Deletar
                                </a>
                              </li>   
                          <?php } ?>
                                                     
                          </ul>
                      </div>
                  <!--FIM DA AÇÂO-->  
                          
                          {{-- Title of task--}}
                  <h3><span class="semi-bold">{{$tarefa2->title}}</span></h3>                    
                          {{-- Description of task--}}
                  <p class="light">{{$tarefa2->description}}</p>
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