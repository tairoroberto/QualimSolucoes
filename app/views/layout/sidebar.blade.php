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
                <a href="{{url('index')}}"><img src="packages/assets/img/Logo-Qualin-interno.png" width="200" height="60"/></a>
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

                                    <?php $countAlerta1;
                                    $tarefaNova = Tarefa::where("date_start","=",date('d/m/Y'))
                                        ->where("SituacaoEtapaTarefa","!=","Finalizado")
                                        ->where("nutricionista_id","=",Auth::user()->get()->id)
                                        ->count();
                                    if(Auth::user()->get()->type == "Administrador"){

                                        $countAlerta1 = Alerta::where("situation", "=", "")
                                            ->where("situation", "!=", "mostrar-para-usuario")->count();
                                    }else{
                                        $countAlerta1 = Alerta::where("situation", "=", "")
                                            ->where("situation", "=", "mostrar-para-usuario")->count();
                                    }?>

                                    <div class="username">
                                        <?php $name = explode(" ", Auth::user()->get()->name);  ?>
                                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        <span class="badge badge-important">{{$tarefaNova+$countAlerta1}}</span>
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

                                    <?php
                                    $alertas;
                                    $countAlerta = 0;
                                    if(Auth::user()->get()->type == "Administrador"){

                                    $alertas = Alerta::where("situation", "=", "")
                                        ->where("situation", "!=", "mostrar-para-usuario")->get();

                                    $countAlerta = Alerta::where("situation", "=", "")
                                        ->where("situation", "!=", "mostrar-para-usuario")->count();

                                    foreach($alertas as $alerta){ ?>

                                    <?php
                                    if($alerta->nutricionista_id != 0){
                                        $userAlert = Nutricionista::find($alerta->nutricionista_id);
                                    }else{
                                        $userAlert = Cliente::find($alerta->cliente_id);
                                    }
                                    ?>

                                    <div class="notification-messages info" >
                                        <div class="user-profile">
                                            @if($alerta->nutricionista_id != 0)
                                                @if(File::exists("packages/assets/img/profiles/".$userAlert->photo))
                                                    <img src="packages/assets/img/profiles/{{$userAlert->photo}}"  alt="" data-src="packages/assets/img/profiles/{{$userAlert->photo}}" data-src-retina="packages/assets/img/profiles/{{$userAlert->photo}}" width="35" height="35" />
                                                @else
                                                    <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png" width="35" height="35" />
                                                @endif
                                            @else
                                                @if(File::exists("packages/assets/img/logo-clientes/".$userAlert->photo_logo))
                                                    <img src="packages/assets/img/logo-clientes/{{$userAlert->photo_logo}}"  alt="" data-src="packages/assets/img/profiles/{{$userAlert->photo_logo}}" data-src-retina="packages/assets/img/profiles/{{$userAlert->photo_logo}}" width="35" height="35" />
                                                @else
                                                    <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png" width="35" height="35" />
                                                @endif
                                            @endif



                                        </div>
                                        <div class="message-wrapper" onclick="deletaAlerta('{{$alerta->id}}');">
                                            <a href="{{action('AlertaController@destroy', $alerta->id)}}">
                                                <div class="heading">
                                                    {{$alerta->msg}}
                                                </div>
                                                <div class="description">
                                                    {{$userAlert->name}}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php
                                    }

                                    }else{
                                    $alertas = Alerta::where("nutricionista_id","=",Auth::user()->get()->id)
                                        ->where("situation", "=", "mostrar-para-usuario")->get();

                                    foreach($alertas as $alerta){ ?>

                                    <?php $userAlert = Nutricionista::find($alerta->admin)?>

                                    <div class="notification-messages info" >
                                        <div class="user-profile">
                                            @if(File::exists("packages/assets/img/profiles/".Auth::user()->get()->photo))
                                                <img src="packages/assets/img/profiles/{{$userAlert->photo}}"  alt="" data-src="packages/assets/img/profiles/{{$userAlert->photo}}" data-src-retina="packages/assets/img/profiles/{{$userAlert->photo}}" width="35" height="35" />
                                            @else
                                                <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png" width="35" height="35" />
                                            @endif

                                        </div>
                                        <div class="message-wrapper">
                                            <a href="{{action('AlertaController@destroy', $alerta->id)}}">
                                                <div class="heading">
                                                    {{$alerta->msg}}
                                                </div>
                                                <div class="description">
                                                    {{$userAlert->name}}
                                                </div>
                                            </a>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>

                                    <?php
                                    }
                                    }
                                    ?>




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





                    {{--Se perfil for do cliente faessa busca por tarefas--}}
                    @if (Auth::cliente()->check())
                        <?php

                        $tarefaAtrasada = Tarefa::where("date_finish","<",date('d/m/Y'))
                            ->where("SituacaoEtapaTarefa","!=","Finalizado")
                            ->where("cliente_id","=",Auth::cliente()->get()->id)
                            ->count();

                        $tarefasAndatmento = Tarefa::where("date_finish",">=",date('d/m/Y'))
                            ->where("SituacaoEtapaTarefa","!=","Finalizado")
                            ->where("cliente_id","=",Auth::cliente()->get()->id)
                            ->count();
                        ?>
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
                                @else
                                    <li><a href="{{action('TarefasController@showTarefasCliente')}}"> Tarefas em aberto<span class="badge badge-important animated bounceIn">{{$tarefasAndatmento}}</span></a>
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
                    <div class="semi-bold"><h6><font color="ffffff">@if(isset($name[0])){{$name[0]}} @endif</font></h6> </div>
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
                                    <li > <a href="{{action('TarefasController@createCliente')}}"> Cadastrar tarefa cliente</a> </li>
                                @endif
                                <li > <a href="{{action('TarefasController@show')}}"> Visualizar tarefas</a> </li>
                                <li > <a href="{{action('TarefasController@showFinish')}}"> Tarefas Finalizadas</a> </li>
                                <li > <a href="{{action('TarefasController@showTarefasAdminCliente')}}"> Visualizar tarefas de clientes</a> </li>
                            </ul>
                        </li>
                    @endif
                @endif


                @if (Auth::cliente()->check())
                    <li class=""> <a href="javascript:;"> <i class="fa fa-tasks"></i>
                            <span class="title">Tarefas</span> <span class="arrow "></span> </a>
                        <ul class="sub-menu">
                            <li > <a href="{{action('TarefasController@showTarefasCliente')}}"> Visualizar tarefas</a> </li>
                        </ul>
                    </li>
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
                                <li > <a href="{{action('RelatorioController@index')}}">Visualizar Auditorias</a> </li>
                                <li > <a href="{{action('RelatorioController@index')}}">Visualizar Check List</a> </li>
                            </ul>
                        </li>
                    @endif
                @endif



                @if (Auth::cliente()->check())
                    <li class=""> <a href="javascript:;"> <i class="fa fa-user"></i>
                            <span class="title">Equipe técnica</span> <span class="arrow "></span> </a>
                        <ul class="sub-menu">
                            <li > <a href="{{action('HomeController@equipe')}}"> Visualizar equipe</a> </li>
                        </ul>
                    </li>
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