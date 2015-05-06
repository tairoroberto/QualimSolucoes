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

   <script type="text/javascript">
       $(document).ready(function () {

           $('#data').datepicker({
               format: "yyyy/mm/dd"
           });

           /*$('.textarea').htmlarea(); //*/
           /*$('.textarea').wysihtml5();*/
           $('#textEditor').Editor();
       });


       function enviar(){
           if(calculaData() == 1 && verificaCliente() == 1){
               $('#relVisitaTecnica').text($('#textEditor').Editor('getText'));
               formRelatorio.submit();
           }else{
               $( "#dialogPreencher" ).dialog({
                   modal: true,
                   buttons: {
                       Ok: function() {
                           $( this ).dialog( "close" );
                       }
                   }
               });
               return;
           }
       }


       jQuery(function(){
           $("#horaInicio").mask("99:99");
           $("#horaFim").mask("99:99");
           $("#totalHoras").mask("99:99");
           $("#data").mask("9999/99/99");
       });

       //seleciona um cliente ao mudar o select
       function selecionaCliente() {
           var c = document.getElementById("selectCliente").value;
           var cliente = c.split(',');
           document.getElementById("cliente_id").value = cliente[0];
           document.getElementById("labelCliente").innerHTML = "<b>Cliente: </b>" + cliente[1];

       }

       function verificaCliente(){
           if (document.getElementById("selectCliente").value == "") {
               $( "#dialogCliente" ).dialog({
                   modal: true,
                   buttons: {
                       Ok: function() {
                           $( this ).dialog( "close" );
                       }
                   }
               });
               return 0;
           }
           return 1;
       }
//calcula a diferença das datas de inicio e fim

 function calculaData() {
      horaInicial = $("#horaInicio").val();
      horaFinal = $("#horaFim").val();

    // Tratamento se a hora inicial é menor que a final 
    if( ! isHoraInicialMenorHoraFinal(horaInicial, horaFinal) ){
       // aux = horaFinal;
        //horaFinal = horaInicial;
       // horaInicial = aux;
        // alert("hora de término deve ser maior que hora de inicio");
        $( "#dialogHora" ).dialog({
            modal: true,
            buttons: {
                Ok: function() {
                    $( this ).dialog( "close" );
                }
            }
        });
        //$("#horaFim").focus();
        return 0;
    }
 
    hIni = horaInicial.split(':');
    hFim = horaFinal.split(':');
 
    horasTotal = parseInt(hFim[0], 10) - parseInt(hIni[0], 10);
    minutosTotal = parseInt(hFim[1], 10) - parseInt(hIni[1], 10);
     
    if(minutosTotal < 0){
        minutosTotal += 60;
        horasTotal -= 1;
    }
     
    horaFinal = horasTotal + ":" + minutosTotal;
    document.getElementById("totalHoras").value = horaFinal;

    return 1;
}

/**
 * Verifica se a hora inicial é menor que a final.
 */
function isHoraInicialMenorHoraFinal(horaInicial, horaFinal){
    horaIni = horaInicial.split(':');
    horaFim = horaFinal.split(':');
 
    // Verifica as horas. Se forem diferentes, é só ver se a inicial 
    // é menor que a final.
    hIni = parseInt(horaIni[0], 10);
    hFim = parseInt(horaFim[0], 10);
    if(hIni != hFim)
        return hIni < hFim;
     
    // Se as horas são iguais, verifica os minutos então.
    mIni = parseInt(horaIni[1], 10);
    mFim = parseInt(horaFim[1], 10);
    if(mIni != mFim)
        return mIni < mFim;
}

/**
* Soma duas horas.
* Exemplo:  12:35 + 07:20 = 19:55.
*/
function somaHora(horaInicio, horaSomada) {
     
    horaIni = horaInicio.split(':');
    horaSom = horaSomada.split(':');
 
    horasTotal = parseInt(horaIni[0], 10) + parseInt(horaSom[0], 10);
    minutosTotal = parseInt(horaIni[1], 10) + parseInt(horaSom[1], 10);
     
    if(minutosTotal >= 60){
        minutosTotal -= 60;
        horasTotal += 1;
    }
     
    horaFinal = horasTotal + ":" + minutosTotal;
    return horaFinal;
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
<body class="">
<!-- BEGIN HEADER -->

<!-- END HEADER -->
<!-- BEGIN CONTAINER -->
  <div class="clearfix"></div>
   <div class="content">        
      {{Form::open(array('id'=>'formRelatorio', 'method'=>'post', 'action'=>'QualimAndroidController@storeVisitaTecnicaAndroid'))}}


                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                        </ul>
                  </div>
                @endif
       

                {{-- Id nutricionista--}}
          <input type="hidden" name="nutricionista_id" id="nutricionista_id" placeholder="Hora de término"
          		value="<?php if (isset($nutricionista->id)) {
          			echo $nutricionista->id;
          		}else{
          			echo Input::old('nutricionista_id');
          			} ?>">
		<input type="hidden" name="nutricionista_name" id="nutricionista_name" placeholder="Hora de término"
          		value="<?php if (isset($nutricionista->name)) {
          			echo $nutricionista->name;
          		}else{
          			echo Input::old('nutricionista_name');
          			} ?>">

           <div class="grid simple">

           {{--Begin cabeçalho relatório--}}
             <div class="grid-body">
                <div class="row">
                  <div class="col-md-12">

                       <select id="selectCliente" name="selectCliente" required="required" class="form-control" onchange="selecionaCliente();">
                              <option value=""><h2>Nome do cliente</h2></option>
                            <?php $clientes = Cliente::all(); ?>
                               @foreach ($clientes as $cliente)
                                 <option value="{{$cliente->id.','.$cliente->razaoSocial;}}">
                                 {{$cliente->razaoSocial}}</option>
                               @endforeach
                       </select>

                      <div class="col-md-3">
                          <h5>{{--<b>Data: </b>--}}<input type="text" id="data" name="data" value="{{date("Y/m/d")}}"></h5>
                      </div>

                    <div class="col-md-3 titulo" align="center">
                       <H5><b>Consultora:</b></H5>
                    </div>

                    <div class="col-md-9 titulo" align="center">
                     <select id="selectNutricionista" name="selectNutricionista" required="required" class="form-control">
                          <option value="<?php if (isset($nutricionista->id)) {
          					echo $nutricionista->id;
		          		}else{
		          			echo Input::old('selectNutricionista');
		          			} ?>"><h2><?php if (isset($nutricionista->id)) {
		          			echo $nutricionista->name;
		          		}else{
		          			echo Input::old('nutricionista_name');;
		          			} ?></h2></option>
                      </select>


                    </div>

                    <br>

                     <div class="col-md-1 titulo" align="center">
                         <input type="text" name="horaInicio" id="horaInicio"  placeholder="Hora de inicio"
                        value="{{Input::old('horaInicio')}}" class="form-control">
                     </div>
                     <div class="col-md-1 titulo" align="center">
                         <input type="text" name="horaFim" id="horaFim"  placeholder="Hora de término"
                        value="{{Input::old('horaFim')}}" onblur="calculaData()" class="form-control">
                      </div>



                      <div class="col-md-12 titulo" align="center">
                         <input type="text" name="totalHoras" id="totalHoras"  placeholder="Total de horas" readonly="true" value="{{Input::old('totalHoras')}}" class="form-control">
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
                           <div class="col-md-12" align="center">
                               <textarea class="textarea" style="width: 100%; height: 400px" name="textEditor" id="textEditor"  rows="6" class="col-lg-12">{{Input::old('relVisitaTecnica')}}</textarea>
                               <textarea class="textarea" name="relVisitaTecnica" id="relVisitaTecnica" hidden="">{{Input::old('relVisitaTecnica')}}</textarea>
                           </div>
                       </div>
                   </div>
               </div>

              {{--Rodapé relatório--}}
              <div class="grid simple">
                 <div class="grid-body">
                   <div class="row">
                      <div class="col-md-7 " >
                         <h5><b>Consultor: </b><?php if (isset($nutricionista->name)) {
								          			echo $nutricionista->name;
								          		}else{
								          			echo Input::old('nutricionista_name');
								          			} ?></h5>
                         <h5><label id="labelCliente"><b>Cliente: </b></label></h5>
                         <input type="hidden" name="cliente_id" id="cliente_id">
                      </div>
                    </div>
                 </div>
              </div>

        </div>


       {{--Diaolog--}}
       <div id="dialogHora" title="Hora incorreta" style="display: none">
           <p>Hora de término deve ser maior que hora de inicio!"</p>
       </div>

       {{--Diaolog--}}
       <div id="dialogCliente" title="Selecione o cliente" style="display: none">
           <p>Selecione o cliente!"</p>
       </div>

       {{--Diaolog--}}
       <div id="dialogPreencher" title="Preencher" style="display: none">
           <p>Preencha todo o relatório!"</p>
       </div>




          <div class="grid simple">
            <div class="grid-body">
            <div class="row">
              <div align="right">
                  <button type="button" class="btn btn-primary" onclick="enviar();">Salvar</button>
              </div>
            </div>
            </div>
         </div>



      {{Form::close()}}



    </div>




  <a href="#" class="scrollup">Subir</a>
   
  <!-- END SIDEBAR --> 
  <!-- BEGIN PAGE CONTAINER-->

<!-- END CHAT --> 
<!-- END CONTAINER -->
<!-- BEGIN FOOTER -->
<!-- END FOOTER -->
<!-- BEGIN CORE JS FRAMEWORK-->

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