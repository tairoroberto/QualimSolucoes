@extends('layout.layout')

@section('content')





    <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
    <div class="clearfix"></div>
    <div class="content">
        <div class="page-title">
            <h3>Equipe - <span class="semi-bold">Técnica</span></h3>
        </div>
        <!-- START FORM -->
        <div class="row">
            <div class="col-md-12">
                <div class="grid simple">

                    <div class="col-md-12 ">
                        <div class="tiles white m-b-20">
                            <div class="tiles-body">
                                <div class="controller"> <a href="javascript:;" class="reload"></a> </div>
                                <br>

                                <?php
                                    $lista = explode(",",Auth::cliente()->get()->nutricionista_id);
                                    $nutricionistas = Nutricionista::whereIn("id",$lista)
                                                                   ->orWhere('name','LIKE', '%Luciana Di Fiori%')
                                                                   ->orWhere('name','LIKE', '%Sara Felix Costa%')->get();
                                ?>

                                @foreach($nutricionistas as $nutricionista)
                                    <div class="notification-messages info" style="height: 100px">
                                        <div class="user-profile" style="width: 69px;height: 69px">
                                            @if(File::exists("packages/assets/img/profiles/".$nutricionista->photo))
                                                <img src="packages/assets/img/profiles/{{$nutricionista->photo}}"  alt="" data-src="packages/assets/img/profiles/{{$nutricionista->photo}}" data-src-retina="packages/assets/img/profiles/{{$nutricionista->photo}}" width="69" height="69" />
                                            @else
                                                <img src="packages/assets/img/profiles/cliente2.png"  alt="" data-src="packages/assets/img/profiles/cliente2.png" data-src-retina="packages/assets/img/profiles/cliente2.png"  width="69" height="69"  />
                                            @endif
                                        </div>
                                        <div class="message-wrapper">
                                            <div class="heading"> {{$nutricionista->name}} </div>
                                            <div class="description"><b>E-mail</b> {{$nutricionista->email}} </div>
                                            <div class="description"><b>Telefone</b> {{$nutricionista->telephone}} </div>
                                            <div class="description"><b>Celular</b> {{$nutricionista->celphone}} </div>
                                        </div>
                                        <div class="date pull-right">  </div>
                                    </div>
                                    <br>
                                @endforeach

                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
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