@extends('layout.layout')

@section('head')
  @parent
   <script type="text/javascript">
       $(document).ready(function () {

           $('#data').datepicker({
               format: "yyyy/mm/dd"
           });

           /*$('.textarea').htmlarea(); //*/
           /*$('.textarea').wysihtml5();*/
           $('#textEditor').Editor();

           $('#textEditor').Editor('setText',[$('#relVisitaTecnica').val()]);
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
           $("#data").mask("99/99/9999");
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

     if(parseInt(hIni[0], 10) < 24 && parseInt(hFim[0], 10) < 24 &&
         parseInt(hIni[1], 10) < 60 && parseInt(hFim[1], 10) < 60 ){
         horaFinal = horasTotal + ":" + minutosTotal;
         $("#totalHoras").val(horaFinal);

         return 1;
     }

     $( "#dialogHoraInvalida" ).dialog({
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


       function deletarFoto(id){
           formRelatorio.action = "{{action('RelatorioController@deletarFotoRelatorio')}}";
           $("#foto_id").val(id);
           formRelatorio.submit();
       }

       var qdivCamposFotos = 0;
       function criarCampoFotos(){
           /*********************************************************************************************/
           /*      						 Cria campos para o Histórico					             */
           /*                                                                                           */
           /*********************************************************************************************/


           var objPai = document.getElementById("DivFotoOrigem");
           //Criando o elemento DIV;
           var objFilho = document.createElement("DivFotoDestino");
           //Definindo atributos ao objFilho:
           objFilho.setAttribute("id","Foto"+qdivCamposFotos);

           //Inserindo o elemento no pai:
           objPai.appendChild(objFilho);
           //Escrevendo algo no filho recem-criado:
           document.getElementById("Foto"+qdivCamposFotos).innerHTML =

               "<div class='col-md-12'>"
               +"<input name='FotosArray[]' id='FotosArray["+qdivCamposFotos+"]' type='file' accept='image/*'  title='Foto "+qdivCamposFotos+"'  class='filestyle btn btn-primary btn-cons'>"
               +"</div>"
           qdivCamposFotos++;

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




      
@stop

@section('content')
  <div class="clearfix"></div>
   <div class="content">  
    <div class="page-title"> 
        
    </div>
      
      {{Form::open(array('id'=>'formRelatorio', 'method'=>'post', 'action'=>'RelatorioController@update', 'files'=>'true'))}}
      

                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                        </ul>
                  </div>
                @endif


      
           <div class="grid simple">    

           {{--Begin cabeçalho relatório--}}          
             <div class="grid-body">
                <div class="row">
                  <div class="col-md-12">



                    <div class="col-md-10 titulo" align="center">
                      <h5><b>RELATÓRIO DE VISITA TÉCNICA</b></h5>
                    </div>
                    <div class="col-md-2">
                        &nbsp;
                    </div>

                    <div class="col-md-7">
                      <h4>
                       <select id="selectCliente" name="selectCliente" required="required" class="form-control" onchange="selecionaCliente();">
                              <option value="{{$cliente->id.','.$cliente->nomeFantasia;}}">{{$cliente->nomeFantasia}}</option>
                           <?php $clientes = Cliente::all(); ?>
                           @foreach ($clientes as $cli)

                               <?php $usersIds = Nutricionista::whereIn("id",explode(',',$cli->nutricionista_id))->get(); ?>
                               @foreach($usersIds as $userId)
                                   @if($userId->id == Auth::user()->get()->id)
                                       <option value="{{$cli->id.','.$cli->nomeFantasia;}}">
                                           {{$cli->nomeFantasia}}
                                       </option>
                                   @endif
                               @endforeach

                           @endforeach
                       </select>                       
                       </h4>
                    </div>

                    <div class="col-md-3">
                        <?php $dataFull = explode(' ', $relatorio->data) ?>
                        <?php $data = explode("-", $dataFull[0]) ?>

                      <h5>{{--<b>Data: </b>--}}<input type="text" id="data" name="data" value="{{$data[2]."/".$data[1]."/".$data[0]}}"></h5>
                    </div>

                    <div class="col-md-2">
                        <img src="packages/assets/img/Logo-Qualin-interno.png" width="140" height="50"/>
                    </div>

                      <div class="col-md-12 titulo" align="center">
                          <H5><b>Consultora:</b></H5>
                      </div>

                    <div class="col-md-12 titulo" align="center">
                         <select id="selectNutricionista" name="selectNutricionista" required="required" class="form-control">
                              <option value="{{$nutricionista->id}}"><h2>{{$nutricionista->name}}</h2></option>
                              <?php $nutricionistas = Nutricionista::all();?>

                                @foreach($nutricionistas as $nutri)
                                    <option value="{{$nutri->id}}"><h2>{{$nutri->name}}</h2></option>
                                @endforeach

                         </select>
                    </div>

                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 form-group">
                      <div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" align="left">
                          <input type="text" name="horaInicio" id="horaInicio"  placeholder="Hora de inicio"
                                 value="{{$relatorio->hora_inicio}}">

                          <input type="text" name="horaFim" id="horaFim"  placeholder="Hora de término"
                                 value="{{$relatorio->hora_fim}}" onblur="calculaData()">

                          <input type="text" name="totalHoras" id="totalHoras"  placeholder="Total de horas" readonly="true" value="{{$relatorio->hora_total}}"
                                 align="right">
                      </div>
                  </div>


                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 titulo" align="center">
                         <h5><b>REGISTRO DAS NÃO CONFORMIDADES E AÇÕES CORRETIVAS</b></h5>
                      </div>            

                  </div>
                </div>                
              </div>
              {{--End cabeçalho relatório--}}


              <div class="grid simple" >              
                 <div class="grid-body">
                   <div class="row">
                    <div class="col-md-12" align="center">
                       <textarea class="textarea" style="width: 100%; height: 400px" name="textEditor" id="textEditor"  rows="6" class="col-lg-12">{{$relatorio->relatorio}}</textarea>
                       <textarea class="textarea" name="relVisitaTecnica" id="relVisitaTecnica" hidden="">{{$relatorio->relatorio}}</textarea>

                        <?php $fotosRelatorio = FotosRelatorio::where("relatorio_id", "=",$relatorio->id)->get();?>
                        <br>

                        @foreach($fotosRelatorio as $foto)
                            <div>
                                <div style="text-align: left">
                                        <button type="button" class="btn btn-primary" onclick="deletarFoto('{{$foto->id}}')">Deletar</button>
                                </div>
                                <img src="packages/assets/img/relatorios/{{$foto->foto}}" width="100%" height="400px">
                                <br><br>
                            </div>
                        @endforeach
                    </div>
                    </div>
                    </div>
                 </div>
              </div>

       {{--Relatorio de visita técinica--}}
       <div class="btn-group">
           <button type="button" class="btn btn-default" onclick="criarCampoFotos();">Adicionar fotos</button><br><br><br>
       </div>
       {{-- Div para criação de campos de e-mails--}}
       <div class="row form-row" id="DivFotoOrigem"></div>
       <div class="row form-row" id="DivFotoDestino"></div>


       {{--Rodapé relatório--}}
              <div class="grid simple">              
                 <div class="grid-body">
                   <div class="row">
                      <div class="col-md-6 titulo" >

                         <h5>
                             <b>
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                 Nome
                             </b>
                         </h5>
                      </div>
                       <div class="col-md-6 titulo" align="center">
                         <h5><b>Assinatura</b></h5>
                      </div>


                      <div class="col-md-7 " >
                         <h5><b>Consultor: </b>{{$nutricionista->name}}</h5>
                         <h5><label id="labelCliente"><b>Cliente: {{$cliente->razaoSocial}}</b></label></h5>
                         <input type="hidden" name="cliente_id" id="cliente_id" value="{{$cliente->id}}">
                      
                      </div>
                      <div class="col-md-5 " >
                         <h5>
                          <b> 
                            @if (Auth::user()->get()->signature != "")
                                @if(File::exists("packages/assets/img/signatures/".$nutricionista->signature))
                                      <img src="packages/assets/img/signatures/{{$nutricionista->signature}}"
                                           width="100%" height="140">
                                @endif
                            @endif
                          </b>
                         </h5>
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

       {{--Diaolog--}}
       <div id="dialogHoraInvalida" title="Preencher" style="display: none">
           <p>Hora não é válida!"</p>
       </div>


       {{--fild to senho id to insert in data base--}}
       <input type="hidden" name="relatorio_id" id="relatorio_id" value="{{$relatorio->id}}">
       <input type="hidden" name="foto_id" id="foto_id">




          <div class="grid simple">
            <div class="grid-body">
            <div class="row">
              <div align="right">
                <button type="reset" class="btn btn-danger">Cancelar</button>
                 <button type="button" class="btn btn-primary" onclick="enviar();">Salvar</button>
              </div>
            </div>                 
            </div>
         </div>

         

      {{Form::close()}}
  </div>
@stop