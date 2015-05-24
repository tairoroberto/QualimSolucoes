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

<script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>

<script type="text/javascript">
  function imprimir(){
    window.print();
    window.history.back();
  }
</script>

<style type="text/css">

.titulo {
  background-color:#BEBEBE;
  
}

table {
  margin-bottom:10px;
  
}

</style>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body onload="imprimir();">

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
                 <div class="grid-body">
                   <div class="row">
                    <div class="col-md-12">
                        <?php $fotosRelatorio = FotosRelatorio::where("relatorio_id", "=",$relatorio_visita->id)->get();?>
                        {{$relatorio_visita->relatorio}}
                        <br>
                        @foreach($fotosRelatorio as $foto)
                            <img src="packages/assets/img/relatorios/{{$foto->foto}}" width="100%" height="400px">
                            <br>
                        @endforeach

                    </div>                              
                    </div>
                 </div>
              </div>

              {{--Rodapé relatório--}}
              <div class="grid simple">              
                 <div class="grid-body">
                   <div class="row">
                      <div class="col-md-6 titulo" >

                         <h5><b>
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                         {{--Nome--}}</b></h5>
                      </div>
                       <div class="col-md-6 titulo" align="center">
                         <h5><b>{{--Assinatura--}}</b></h5>
                      </div>


                      <div class="col-md-7 " >
                         <h5><b>Consultor: </b>{{$nutricionista->name}}</h5>
                         <h5><label id="labelCliente"><b>Cliente: </b>{{$cliente->razaoSocial}}</label></h5>
                         <input type="hidden" name="cliente_id" id="cliente_id">

                         <div align="right">
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
<!-- END CHAT --> 
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
<!-- BEGIN CORE JS FRAMEWORK-->

<script src="packages/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>

<!-- END CORE PLUGINS -->


<!-- END PAGE LEVEL PLUGINS -->




</body>
</html>