@extends('layout.layout')

@section('head')
    @parent

    <style type="text/css">

        .titulo {
            background-color:#BEBEBE;

        }

        table {
            margin-bottom:10px;

        }

    </style>





@stop

@section('content')
    <div class="clearfix"></div>
    <div class="content">
        <div class="page-title">

        </div>

        {{--Form::open(array('id'=>'formRelatorio', 'method'=>'post', 'action'=>'RelatorioController@storeVisitaTecnica'))--}}



        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                </ul>
            </div>
        @endif

        {{--busca o relatório--}}
        <?php //$relatorio_visita = RelatorioVisita::find($relatorio_id); ?>

        <?php $nutricionista = Nutricionista::find($relatorio_visita->nutricionista_id) ?>
        <?php $cliente = Cliente::find($relatorio_visita->cliente_id) ?>


        <div class="grid simple">

            {{--Begin cabeçalho relatório--}}
            <div class="grid-body">
                <div class="row">
                    <div class="col-md-12">


                        <div class="col-md-10 titulo" align="center">
                            <h5><b>RELATÓRIO DE VISITA TÉCNICA</b></h5>
                        </div>

                        <div class="col-md-2" align="right">
                            <img src="packages/assets/img/Logo-Qualin-interno.png" width="140" height="40"/>
                        </div>

                        <div class="col-md-12 ">
                            <h5 align="">
                                <b>Cliente:</b> {{$cliente->razaoSocial}}
                            </h5>
                        </div>



                        <div class="col-md-10 " align="">

                            <H5><b>
                                    Consultora:</b> {{$nutricionista->name}}</h5>
                        </div>
                        <div class="col-md-2">
                            {{--função para mostrar data--}}
                            <?php $data = explode(" ", $relatorio_visita->created_at) ?>
                            <?php $data = explode("-", $data[0]) ?>

                            <h5><b>Data: </b>{{$data[2]."/".$data[1]."/".$data[0]}}</h5>
                        </div>

                        <div class="col-md-12" >

                            Hora de início: {{$relatorio_visita->hora_inicio}}
                            &nbsp;&nbsp;&nbsp;&nbsp;
                            Hora de término: {{$relatorio_visita->hora_fim}}

                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

                            Total de horas: {{$relatorio_visita->hora_total}}hs

                        </div>



                        <div class="col-md-12 titulo" align="center">
                            <h5><b>REGISTRO DAS NÃO CONFORMIDADES E AÇÕES CORRETIVAS</b></h5>
                        </div>

                    </div>
                </div>
            </div>
            {{--End cabeçalho relatório--}}

            {{--Relatorio de visita técinica--}}

            <div class="grid simple" >
                <div class="grid-body" style="background-image: url('packages/assets/img/Logo-Qualin-trasparente.png'); background-repeat: no-repeat; background-position: center; background-size: 1600px">
                    <div class="row">
                        <div class="col-md-12" >
                            <?php $fotosRelatorio = FotosRelatorio::where("relatorio_id", "=",$relatorio_visita->id)->get();?>
                            {{$relatorio_visita->relatorio}}
                            <br><br><br>
                            @foreach($fotosRelatorio as $foto)
                                <img src="packages/assets/img/relatorios/{{$foto->foto}}" width="100%" height="400px">
                                <br><br>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{--Rodapé relatório--}}
            <div class="grid simple">
                <div class="grid-body">
                    <div class="row">
                        <div class="col-md-12 titulo" >

                            <h5><b>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    {{--Nome--}}</b></h5>
                        </div>

                        <div class="col-md-12 " >
                            <h5><b>Consultor: </b>{{$nutricionista->name}}</h5>
                            <h5><label id="labelCliente"><b>Cliente: </b>{{$cliente->razaoSocial}}</label></h5>
                            <input type="hidden" name="cliente_id" id="cliente_id">

                            <div style="float: right;">
                                @if ($nutricionista->signature != "")
                                    @if(File::exists("packages/assets/img/signatures/".$nutricionista->signature))
                                        <img src="packages/assets/img/signatures/{{$nutricionista->signature}}"
                                             width="270" height="80">
                                    @endif
                                @endif
                            </div>

                        </div>

                    </div>

                </div>
            </div>

        </div>




        <div class="grid simple" onmouseover="calculaData();">
            <div class="grid-body">
                <div class="row">
                    <div align="right">
                    </div>
                </div>
            </div>



            {{--Form::close()--}}



        </div>




    </div>
    <a href="#" class="scrollup">Subir</a>

    <!-- END SIDEBAR -->
    <!-- BEGIN PAGE CONTAINER-->
    </div>
    </div>
@stop