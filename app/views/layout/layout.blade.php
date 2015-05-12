<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<meta charset="utf-8" />
<title>Qualim | Soluções</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
<meta content="" name="description" />
<meta content="" name="author" />

<!-- BEGIN PLUGIN CSS -->
<link href="packages/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/bootstrap-tag/bootstrap-tagsinput.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/dropzone/css/dropzone.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/bootstrap-datepicker/css/datepicker.css" rel="stylesheet" type="text/css" />
<link href="packages/assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.css" rel="stylesheet" type="text/css" />
<link href="packages/assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.css" rel="stylesheet" type="text/css" />
<link href="packages/assets/plugins/ios-switch/ios7-switch.css" rel="stylesheet" type="text/css" media="screen">
<link href="packages/assets/plugins/bootstrap-select2/select2.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/datatables-responsive/css/datatables.responsive.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="packages/assets/plugins/jquery-datatable/css/jquery.dataTables.css" rel="stylesheet" type="text/css"/>

<!-- END PLUGIN CSS -->

<!-- BEGIN CORE CSS FRAMEWORK -->
<link href="packages/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
<!-- END CORE CSS FRAMEWORK -->

<!-- BEGIN CSS TEMPLATE -->
<link href="packages/assets/css/style.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
<link href="packages/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>
<!-- END CSS TEMPLATE -->

<link href="packages/assets/plugins/boostrap-slider/css/slider.css" rel="stylesheet" type="text/css"/>
<script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery-mask/jquery.maskedinput.js"></script>
<script type="text/javascript" src="packages/assets/js/bootstrap.file-input.js"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery-mask/jquery.mask.js"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery.maskMoney.min.js"></script>
<script type="text/javascript" src="packages/assets/js/CriarComponentes.js"></script>
<script type="text/javascript" src="packages/assets/plugins/bootstrap-progressbar.js"></script>
<link rel="stylesheet" type="text/css" href="packages/assets/plugins/bootstrap-wysihtml5/style/jHtmlArea.css">
<script type="text/javascript" src="packages/assets/plugins/bootstrap-wysihtml5/scripts/jHtmlArea-0.8.js"></script>

<link href="packages/assets/plugins/bootstrap-wysihtml5/Responsive-WYSIWYG/editor.css" type="text/css" rel="stylesheet"/>
<script src="packages/assets/plugins/bootstrap-wysihtml5/Responsive-WYSIWYG/editor.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
<script src="//code.jquery.com/ui/1.11.4/jquery-ui.js"></script>

<link rel="stylesheet" href="packages/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>

@yield('head')

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="">
<!-- BEGIN HEADER -->
<div class="header navbar navbar-inverse "> 
  <!-- BEGIN TOP NAVIGATION BAR -->
  <div class="navbar-inner">
  <div class="header-seperation"> 
    <ul class="nav pull-left notifcation-center" id="main-menu-toggle-wrapper" style="display:none">  
     <li class="dropdown"> <a id="main-menu-toggle" href="#main-menu"  class="" > <div class="iconset top-menu-toggle-white"></div> </a> </li>     
    </ul>
      <!-- BEGIN LOGO --> 
        <div align="center">
          <a href="#"><img src="packages/assets/img/Logo-Qualin-interno.png" width="200" height="60"/></a>
        </div>
      <!-- END LOGO --> 
      <ul class="nav pull-right notifcation-center">  
      
       
         
      </ul>
      </div>
      <!-- END RESPONSIVE MENU TOGGLER --> 
      <div class="header-quick-nav" > 
      <!-- BEGIN TOP NAVIGATION MENU -->
  
   <!-- END TOP NAVIGATION MENU -->
   <!-- BEGIN CHAT TOGGLER -->
{{-- Se usuario logado for cliente não mosta barra de tarefas superior--}}
   @if (Auth::user()->check() || Auth::cliente()->check())    

      <div class="pull-right"> 

      @if (Auth::user()->check())
         <div class="chat-toggler">  
            <a href="#" class="dropdown-toggle" id="my-task-list" data-placement="bottom"  data-content='' data-toggle="dropdown" data-original-title="Notificações">
              <div class="user-details"> 

              <?php $tarefaNova = Tarefa::where("date_start","=",date('d/m/Y'))
                                        ->where("SituacaoEtapaTarefa","!=","Finalizado")
                                        ->where("nutricionista_id","=",Auth::user()->get()->id)
                                        ->count();?>

                <div class="username">
                    <?php $name = explode(" ", Auth::user()->get()->name);  ?>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                  <span class="badge badge-important">{{$tarefaNova}}</span> 
                  {{$name[0]}} <span class="bold"></span>                  
                </div>            
              </div> 
              <div class="iconset top-down-arrow"></div>
            </a>  
            <div id="notification-list" style="display:none">
              <div style="width:300px">
               <?php 

                    $tarefaAtrasada = Tarefa::where("date_finish","<",date('d/m/Y'))
                                            ->where("SituacaoEtapaTarefa","!=","Finalizado")
                                            ->where("nutricionista_id","=",Auth::user()->get()->id)
                                            ->count();

                    $tarefasAndatmento = Tarefa::where("date_finish",">=",date('d/m/Y'))
                                               ->where("SituacaoEtapaTarefa","!=","Finalizado")
                                               ->where("nutricionista_id","=",Auth::user()->get()->id)
                                               ->count(); ?>


                 <div class="notification-messages sucess">
                     <div class="description">
                        <a href="{{action('TarefasController@show')}}">{{$tarefaNova}} tarefas Nova(s)</a>
                      </div> 
                   <div class="clearfix"></div>                  
                </div> 


                 <div class="notification-messages info">
                  <div class="description">
                      <a href="{{action('TarefasController@show')}}"> {{$tarefasAndatmento}} tarefas com o prazo para acabar</a>
                      </div> 
                   <div class="clearfix"></div>                  
                </div> 


                  <div class="notification-messages danger">
                    <div class="iconholder">
                      <i class="icon-warning-sign"></i>
                    </div>
                    <div class="message-wrapper">
                      <div class="heading">
                        Atenção
                      </div>                  
                      <div class="">
                        <a href="{{action('TarefasController@show')}}"> {{$tarefaAtrasada}} tarefas Atrada(s)</a>
                      </div>
                    </div>




                    <div class="clearfix"></div>
                  </div>              
                </div>        
            </div>


            <div class="profile-pic">
                @if(File::exists("packages/assets/img/profiles/".Auth::user()->get()->photo))
                    <img src="packages/assets/img/profiles/{{Auth::user()->get()->photo}}"  alt="" data-src="packages/assets/img/profiles/{{Auth::user()->get()->photo}}" data-src-retina="packages/assets/img/profiles/{{Auth::user()->get()->photo}}" width="35" height="35" />
                @else
                    <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png" width="35" height="35" />
                @endif
            </div>
         </div>
      @endif
   




     <ul class="nav quick-section ">
      <li class="quicklinks"> 
        <a data-toggle="dropdown" class="dropdown-toggle  pull-right " href="#" id="user-options">            
          <div class="iconset top-settings-dark "></div>  
        </a>
            <ul class="dropdown-menu  pull-right" role="menu" aria-labelledby="user-options">
               
                 @if (Auth::user()->check())
                    <li><a href="{{action('NutricionistasController@editConta')}}"> Minha Conta</a>
                    </li>
                    <li><a href="{{action('CalendarioController@create')}}">Meu calendario</a>
                    </li>
                    <li><a href="{{action('TarefasController@show')}}"> Tarefas em aberto<span class="badge badge-important animated bounceIn">{{$tarefasAndatmento}}</span></a>
                    </li>
                  @endif

                  <li class="divider"></li>                
                  <li><a href="{{action('HomeController@makeLogout')}}"><i class="fa fa-power-off"></i>&nbsp;&nbsp;Sair</a></li>
               </ul>
         </li>       
       </ul>


     </div>

   @endif











     <!-- END CHAT TOGGLER -->
      </div> 
      <!-- END TOP NAVIGATION MENU --> 
   
  </div>
  <!-- END TOP NAVIGATION BAR --> 
</div>
<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
<div class="page-container row-fluid">
  <!-- BEGIN SIDEBAR -->
  <div class="page-sidebar" id="main-menu"> 
  <!-- BEGIN MINI-PROFILE -->
   <div class="page-sidebar-wrapper" id="main-menu-wrapper"> 
   <div class="user-info-wrapper">  
  <div class="profile-wrapper">


{{--verify if the user is logged, if user was be logged show the user´s photo--}} 
  @if (Auth::user()->check())
          @if(File::exists("packages/assets/img/profiles/".Auth::user()->get()->photo))
              <img src="packages/assets/img/profiles/{{Auth::user()->get()->photo}}"  alt="" data-src="packages/assets/img/profiles/{{Auth::user()->get()->photo}}" data-src-retina="packages/assets/img/profiles/{{Auth::user()->get()->photo}}"  width="69" height="69"  />
          @else
              <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png"  width="69" height="69"  />
          @endif
  @endif


{{--verify if the client is logged, if client was be logged show the client´s photo--}} 
  @if (Auth::cliente()->check())
  {{--aqui--}}
      @if (Auth::cliente()->get()->photo_logo))
          @if(File::exists("packages/assets/img/logo-clientes/".Auth::cliente()->get()->photo_logo))
              <img src="packages/assets/img/logo-clientes/{{Auth::cliente()->get()->photo_logo}}"  alt="" data-src="packages/assets/img/profiles/{{Auth::cliente()->get()->photo_logo}}" data-src-retina="packages/assets/img/profiles/{{Auth::cliente()->get()->photo_logo}}"  width="69" height="69"  />
          @else
              <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png"  width="69" height="69"  />
          @endif
      @else
        <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png" width="69" height="69" />
      @endif
      {{--Aqui--}}
       
  @endif
   
  </div>

    <div class="user-info">
    <?php $name; ?>

    {{--verify if the user is logged, if user was be logged take the user´s name--}} 
    @if (Auth::user()->check())
       <?php $name = explode(" ", Auth::user()->get()->name);  ?>  
    @endif

    {{--verify if the client is logged, if client was be logged take the client´s name--}} 
    @if (Auth::cliente()->check())
       <?php $name = explode(",", Auth::cliente()->get()->nomeFantasia);  ?>  
    @endif  


     
      <div class="greeting"><h5><font color="ffffff"><br></font></h5></div>
      <div class="semi-bold"><h6><font color="ffffff">{{$name[0]}}</font></h6> </div>
      <div class="status">
         <h5>
           <font color="ffffff"> 
             @if (Auth::user()->check())
               {{Auth::user()->get()->type}} 
             @endif

             @if (Auth::cliente()->check())
               {{Auth::cliente()->get()->type}} 
             @endif

           </font>
         </h5>
       </div>
     </div>
   </div>
  <!-- END MINI-PROFILE -->
   
<!-- BEGIN SIDEBAR MENU --> 
  
    <ul>  
     
     @if ((Auth::user()->check()) && (Auth::user()->get()->type == "Administrador"))     
       <li class=""> <a href="javascript:;"> <i class="fa fa-sitemap"></i> 
        <span class="title">Consultoras</span> <span class="arrow "></span> </a>
          <ul class="sub-menu">
            <li > <a href="{{action('NutricionistasController@create')}}"> Cadastrar Consultora</a> </li>
            <li > <a href="{{action('NutricionistasController@show')}}"> Visualizar Consultoras</a> </li>
              @if ((Auth::user()->get()->type == "Administrador"))
                  <li > <a href="{{action('NutricionistasController@restoreUserList')}}"> Visualizar Consultoras Excluídas</a> </li>
              @endif
          </ul>
        </li>
     @endif   


     @if ((Auth::user()->check()) && (Auth::user()->get()->type == "Administrador"))    
      <li class=""> <a href="javascript:;"> <i class="fa fa-building-o"></i>
       <span class="title">Cliente</span> <span class="arrow "></span> </a>
        <ul class="sub-menu">
          <li > <a href="{{action('ClienteController@create')}}"> Cadastrar cliente</a> </li>
          <li > <a href="{{action('ClienteController@show')}}"> Visualizar clientes</a> </li>
        </ul>
      </li>
      @endif   




    @if (Auth::user()->check())
       @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Consultora") || (Auth::user()->get()->type == "Supervisora"))
            <li class=""> <a href="javascript:;"> <i class="fa fa-tasks"></i> 
              <span class="title">Tarefas</span> <span class="arrow "></span> </a>
                <ul class="sub-menu">
                  @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Supervisora"))     
                     <li > <a href="{{action('TarefasController@create')}}"> Cadastrar tarefa</a> </li> 
                   @endif 
                  <li > <a href="{{action('TarefasController@show')}}"> Visualizar tarefas</a> </li>  
                  <li > <a href="{{action('TarefasController@showFinish')}}"> Tarefas Finalizadas</a> </li>  
                </ul>
              </li>
        @endif   
    @endif   
     
    



    @if (Auth::user()->check())
       @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Consultora") || (Auth::user()->get()->type == "Supervisora"))    
          <li class=""> <a href="javascript:;"> <i class="fa fa-calendar"></i>
          <span class="title">Cronograma </span> <span class="arrow "></span> </a>
            <ul class="sub-menu">
             <li > 
                <a href="{{action('CalendarioController@create')}}"> Cadastrar Cronograma</a> 
             </li>  
              @if (Auth::user()->get()->type == "Administrador" || (Auth::user()->get()->type == "Supervisora"))
                  <li > 
                    <a href="{{action('CalendarioController@mostrarCronogramaLista')}}"> Visualizar Cronograma</a> 
                 </li> 
              @endif 

            </ul>
          </li>
        @endif   
    @endif  



    @if (Auth::user()->check())
       @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Consultora") || (Auth::user()->get()->type == "Supervisora"))  
          <li class=""> <a href="javascript:;"> <i class="fa fa-external-link"></i>
          <span class="title">Relatórios </span> <span class="arrow "></span> </a>
            <ul class="sub-menu">
              <li > <a href="{{action('RelatorioController@create')}}">Cadastrar visitas Técnicas </a> </li>
              <li > <a href="{{action('RelatorioController@index')}}">Visualizar visitas Técnicas</a> </li>
              <li > <a href="{{action('RelatorioController@create')}}">Cadastrar Auditorias</a> </li>
              <li > <a href="{{action('RelatorioController@create')}}">Visualizar Auditorias</a> </li>
              <li > <a href="{{action('RelatorioController@create')}}">Cadastrar Check List</a> </li>    
              <li > <a href="{{action('RelatorioController@create')}}">Visualizar Check List</a> </li>       
            </ul>
          </li>
        @endif   
    @endif 


    @if (Auth::cliente()->check())
       @if (Auth::cliente()->get()->type == "cliente")  
          <li class=""> <a href="javascript:;"> <i class="fa fa-external-link"></i>
          <span class="title">Relatórios </span> <span class="arrow "></span> </a>
            <ul class="sub-menu">
              <li > <a href="{{action('RelatorioController@index')}}">Visualizar visitas Técnicas</a></li>
              <!-- <li > <a href="{{action('RelatorioController@create')}}">Visualizar Auditorias</a> </li>
              <li > <a href="{{action('RelatorioController@create')}}">Visualizar Check List</a> </li>    --> 
            </ul>
          </li>
        @endif   
    @endif 



    @if (Auth::user()->check())
       @if ((Auth::user()->get()->type == "Administrador") || (Auth::user()->get()->type == "Consultora") || (Auth::user()->get()->type == "Supervisora"))  
           <li class=""> <a href="javascript:;"> <i class="fa fa-external-link"></i>
          <span class="title">Prestação de contas </span> <span class="arrow "></span> </a>
            <ul class="sub-menu">
              <li > <a href="{{action('GastosController@create')}}">Inserir</a> </li>
              <li > <a href="{{action('GastosController@index')}}">Ver</a> </li>      
            </ul>
          </li>
        @endif   
    @endif 
      
    </ul>
  
  
      </div>
    </div>
  </div>  
  <div class="clearfix"></div>
    <!-- END SIDEBAR MENU --> 
  </div>
  </div>
  <a href="#" class="scrollup">Subir</a>
  <div class="page-content">


    @yield("content")







    </div>




 </div>
  <a href="#" class="scrollup">Subir</a>
   
  <!-- END SIDEBAR --> 
  <!-- BEGIN PAGE CONTAINER-->
  </div>
 </div>
<!-- END CHAT --> 
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
<!-- BEGIN CORE JS FRAMEWORK-->
<script type="text/javascript" src="packages/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>

<script src="packages/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/breakpoints.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>

<!-- END CORE JS FRAMEWORK -->
<script src="packages/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script> 
<!-- END CORE PLUGINS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="packages/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script> 
<script src="packages/assets/plugins/bootstrap-datepicker/js/bootstrap-datepicker.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-inputmask/jquery.inputmask.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-autonumeric/autoNumeric.js" type="text/javascript"></script>
<script src="packages/assets/plugins/ios-switch/ios7-switch.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-select2/select2.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-wysihtml5/wysihtml5-0.3.0.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-wysihtml5/bootstrap-wysihtml5.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap-tag/bootstrap-tagsinput.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/dropzone/dropzone.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-datatable/js/jquery.dataTables.min.js" type="text/javascript" ></script>
<script src="packages/assets/plugins/jquery-datatable/extra/js/TableTools.min.js" type="text/javascript" ></script>
<script type="text/javascript" src="packages/assets/plugins/datatables-responsive/js/datatables.responsive.js"></script>
<script type="text/javascript" src="packages/assets/plugins/datatables-responsive/js/lodash.min.js"></script>
<script src="packages/assets/js/datatables.js" type="text/javascript"></script>

<!-- END PAGE LEVEL PLUGINS -->



<!-- END PAGE LEVEL PLUGINS -->
<script src="packages/assets/js/form_elements.js" type="text/javascript"></script>
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="packages/assets/js/core.js" type="text/javascript"></script>
<script src="packages/assets/js/chat.js" type="text/javascript"></script> 
<script src="packages/assets/js/demo.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- END JAVASCRIPTS -->
<script type="text/javascript">
 /* 
  $(document).ready( function() {
  $('#example').dataTable( {
    "oLanguage": {
      "sSearch": "Buscar:"
    }
  } );
} );
*/


</script>

</body>
</html>