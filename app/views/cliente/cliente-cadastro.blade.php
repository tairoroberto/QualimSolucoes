@extends('layout.layout')

@section('head')
  @parent
  <script type="text/javascript">
   jQuery(function(){
   $("#telefone").mask("(99) 9999-9999");
   $("#celular_contato").mask("(99) 9999-99999");
   $("#telefone_contato").mask("(99) 9999-9999");

   $("#cnpj").mask("99.999.999/9999-99");
   $("#cep").mask("99.999-999");
});


   $(document).ready(function(){
    $('input[type=file]').bootstrapFileInput();
  });
   

function chamaModal(){
 $('#myModal').modal('show');    
}


$(document).on("click", "#btnBuscarDados", function(e){
    $('#Carregando').css('display','block');
    $('.div-ajax-carregamento-pagina').fadeOut('fast');

    //$(this).load('inlcudes/populate.php');     
    var cnpj = document.getElementById('cnpj').value;
    var captcha = document.getElementById('captcha').value;
    //var viewstate = document.getElementById('viewstate').value;
    var cookie = document.getElementById('cookie').value;
    $.ajax({
        url: "{{action('ClienteController@buscaDados')}}",
        data: {cnpj : cnpj, captcha : captcha/*,viewstate : viewstate*/,cookie : cookie},
        type: "POST",
        success: function (json) {

        $('#Carregando').css('display','none');

          if (json == "Captcha incorreto") {
              alert('Captcha incorreto');
              location.reload();
              return;
          }else{
            var resposta = JSON.parse(json);
            document.getElementById('razaoSocial').value = resposta['razao_social'];
            document.getElementById('nomeFantasia').value = resposta['nome_fantasia'];
            document.getElementById('endereco').value = resposta['logradouro'];
            document.getElementById('numero').value = resposta['numero'];    
            document.getElementById('bairro').value = resposta['bairro'];
            document.getElementById('complemento').value = resposta['complemento'];                
            document.getElementById('cidade').value = resposta['cidade'];    
            document.getElementById('cep').value = resposta['cep'];
            document.getElementById('telefone').value = resposta['TELEFONE'];
          }            
        }
    });
});

   /********************************************************************************************/
   /*                       Função para a busca de CEP do Responsável                          */
   /********************************************************************************************/
   function buscarCep(){
       //Nova variável com valor do campo "cep".
       var cep = $("#cep").val().replace(".", "");
       cep = cep.replace("-", "");

       //Verifica se campo cep possui valor informado.

       //Preenche os campos com "..." enquanto consulta webservice.
       $("#bairro").val("...");
       $("#cidade").val("...");
       $("#endereco").val("...");

       //Consulta o webservice viacep.com.br/
       $.getJSON("//viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

           if (!("erro" in dados)) {
               //Atualiza os campos com os valores da consulta.
               $("#bairro").val(dados.bairro);
               $("#cidade").val(dados.localidade);
               $("#endereco").val(dados.logradouro);
               $("#numero").val("");
               $("#numero").focus();
           } //end if.
           else {
               //CEP pesquisado não foi encontrado.
               alert("CEP não encontrado.");
           }
       });
   }
</script>


  <script type="text/javascript">
        var qdivCamposEmail = 0;

/*********************************************************************************************/
/*                   Cria campos para o Histórico                      */
/*                                                                                           */
/*********************************************************************************************/
  
    function criarCampoEmail(){
      
    var objPai = document.getElementById("DivEmailOrigem");
    //Criando o elemento DIV;
    var objFilho = document.createElement("DivEmailDestino");
    //Definindo atributos ao objFilho:
    objFilho.setAttribute("id","Email"+qdivCamposEmail);
    
    //Inserindo o elemento no pai:
    objPai.appendChild(objFilho);
    //Escrevendo algo no filho recem-criado:
    document.getElementById("Email"+qdivCamposEmail).innerHTML =          
    "<div class='col-md-12'>"
        +"<input name='emailArray[]' id='emailArray[]' type='text'  class='form-control' placeholder='E-mail da empresa'>"
        +"</div>";
     qdivCamposEmail++;
}




  $(document).ready(function(){

    $('#nutricionista_id').multiselect({
            buttonText: function(options, select) {
                if (options.length === 0) {
                    return 'Selecione a consultora Responsável';
                }
                else if (options.length > 4) {
                    return alert("Selecione até 5 consultoras");
                }
                 else {
                     var labels = [];
                     options.each(function() {
                         if ($(this).attr('label') !== undefined) {
                             labels.push($(this).attr('label'));
                         }
                         else {
                             labels.push($(this).html());
                         }
                     });
                     return labels.join(', ') + ' ';
                 }
            },
           buttonWidth: '300px',
        });
  });

  </script>

  <style>
      .jquery-waiting-base-container {
          position: absolute;
          left: 0px;
          top: 20%;
          margin:0px;
          width: 100%;
          height: 200px;
          display:block;
          z-index: 9999997;
          opacity: 0.65;
          -moz-opacity: 0.65;
          filter: alpha(opacity = 65);
          background: black;
          background-image: url("packages/assets/img/loading_bar.gif");
          background-repeat: no-repeat;
          background-position:50% 50%;
          text-align: center;
          overflow: hidden;
          font-weight: bold;
          color: white;
          padding-top: 25%;
      }
  </style>

  <!--MultiSelect-->
<link rel="stylesheet" type="text/css" href="packages/assets/plugins/bootstrap-multiselect/css/bootstrap-multiselect.css">
<script type="text/javascript" src="packages/assets/plugins/bootstrap-multiselect/js/bootstrap-multiselect.js"></script>


@stop

@section('content')
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Cadastro - <span class="semi-bold">Cliente</span></h3>
              </div>
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-24">
                  <div class="grid simple">
                
                    <div class="grid-body no-border">
                    {{Form::open(array('action' => 'ClienteController@store', 'files' => 'true'))}}


                     @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                  {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                              </ul>
                        </div>
                      @endif

                      <div class="row column-seperation">
                        <div class="col-md-24">
                         <p></p> <p></p>
                         <div class="row form-row">

                      <div class="col-md-6">
                          <input name="razaoSocial" id="razaoSocial" type="text"  class="form-control" placeholder="Razão social" value="{{Input::old('razaoSocial')}}">   
                      </div>

                      <div class="col-md-6">
                          <input name="nomeFantasia" id="nomeFantasia" type="text"  class="form-control" placeholder="Nome fantasia" value="{{Input::old('nomeFantasia')}}">   
                      </div>


                      <div class="col-md-3">
                        <input name="cnpj" id="cnpj" type="text"  class="form-control" placeholder="CNPJ " value="{{Input::old('cnpj')}}" onblur="chamaModal();">
                      </div>
                      
                      <div class="col-md-6">
                        <input name="endereco" id="endereco" type="text"  class="form-control" placeholder="Endereço " value="{{Input::old('endereco')}}">
                      </div>
                      <div class="col-md-3">
                        <input name="numero" id="numero" type="text"  class="form-control" placeholder="Numero " value="{{Input::old('numero')}}">
                      </div>

                      <div class="col-md-2"> 
                          <input name="bairro" id="bairro" type="text"  class="form-control" placeholder="Bairro" value="{{Input::old('bairro')}}">   
                      </div>
                      <div class="col-md-10"> 
                          <input name="complemento" id="complemento" type="text"  class="form-control" placeholder="Complemento" value="{{Input::old('complemento')}}">   
                      </div>

                    </div>
                    
                    <div class="row form-row">
                      <div class="col-md-5">
                        <input name="cidade" id="cidade" type="text"  class="form-control" placeholder="Municipio " value="{{Input::old('cidade')}}">
                      </div>

                      <div class="col-md-3">
                        <input name="cep" id="cep" type="text"  class="form-control" placeholder="CEP " value="{{Input::old('cep')}}"
                            onblur="buscarCep()">
                      </div>


                      <div class="col-md-4">
                          <input name="telefone" id="telefone" type="text"  class="form-control" placeholder="Telefone empresa" value="{{Input::old('telefone')}}">   
                      </div>
                    </div>


                    
                    <div class="row form-row">
                      
                      <div class="col-md-6">
                        <input name="contato" id="contato" type="text"  class="form-control" placeholder="Nome do contato " value="{{Input::old('contato')}}">
                      </div>

                      <div class="col-md-3">
                        <input name="telefone_contato" id="telefone_contato" type="text"  class="form-control" placeholder="Telefone do contato" value="{{Input::old('telefone_contato')}}">
                      </div>

                      <div class="col-md-3">
                        <input name="celular_contato" id="celular_contato" type="text"  class="form-control" placeholder="Celular do contato" value="{{Input::old('celular_contato')}}">
                      </div>
                      
                     </div>

                     <div class="row form-row">
                      
                      <div class="col-md-8">
                        <input name="email_contato" id="email_contato" type="text"  class="form-control" placeholder="Email do contato " value="{{Input::old('email_contato')}}">
                      </div>
                      <div class="col-md-4">                        
                        <select name="nutricionista_id[]" id="nutricionista_id" multiple class="form-control" required="required">
                        @foreach ($nutricionistas as $nutricionista)
                          <option value="{{$nutricionista->id}}">{{$nutricionista->name}}</option>
                        @endforeach                       
                      </select>
                      </div> 


                      {{--Email para login / aqui está como e-mail porém --}}
                      <div class="col-md-6">
                        <input name="email" id="email" type="text"  class="form-control" placeholder="Usuário para Login do cliente" value="{{Input::old('email')}}">
                      </div>

                      <div class="col-md-3">
                        <input name="senha" id="senha" type="password"  class="form-control" placeholder="Senha " value="{{Input::old('senha')}}">
                      </div>

                      <div class="col-md-3">
                        <input name="senha_confirmation" id="senha_confirmation" type="password"  class="form-control" placeholder="Confirma senha " value="{{Input::old('senha_confirmation')}}">
                      </div> 
                      
                     </div>


                     {{-- Div para criação de campos de e-mails--}}
                      <div class="row form-row" id="DivEmailOrigem"></div>
                      <div class="row form-row" id="DivEmailDestino"></div>
                   


                    
                         </div>                       
                       </div>

                        <div class="form-actions">
                            <div class="pull-left"></div>
                            <div class="pull-right col-md-12">
                                <div class="pull-left col-md-3">
                                    <button class="btn btn-primary btn-cons" type="button" onclick="criarCampoEmail();">
                                        Adicionar campo de e-mail
                                    </button>
                                </div>

                                <div class="pull-left col-md-5">
                                    <input name="logo" id="logo" type="file" accept="image/*"
                                           class="filestyle btn btn-primary btn-cons"
                                           title="Selecione a logomarca do cliente" value="{{Input::old('logo')}}"/>
                                </div>

                                <div class="pull-right col-md-4">
                                    <button class="btn btn-primary btn-cons" type="submit"
                                            onclick="verificaResponsavel();">Salvar
                                    </button>
                                    <button class="btn btn-danger btn-cons" type="reset">Cancelar</button>
                                </div>

                            </div>
                        </div>

                          <div class="modal fade" id="myModal">
                              <div class="modal-dialog">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <h4 class="modal-title">Insira o Captha pra buscar os dados do cliente</h4>
                                  </div>
                                  <?php
                                   $params = CnpjGratis::getParams(); ?>
                                  <div class="modal-body" align="center">                                  
                                  <img src="<?php echo $params['captchaBase64']; ?>" id="imgCaptcha" name="imgCaptcha" class='img-responsive' width="200" height="100"><br>

                                    <input type='text' class='form-control' name='captcha' id='captcha' >
                                   <!--  <input type='hidden' class='form-control' name='viewstate' id='viewstate' value="<?php //echo $params['viewstate']; ?>"> -->
                                    <input type='hidden' class='form-control' name='cookie' id='cookie' value="<?php echo $params['cookie']; ?>">
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                                    <button type="button" id="btnBuscarDados" class="btn btn-primary"  data-dismiss="modal" >Buscar dados de cliente</button>
                                  </div>
                                </div><!-- /.modal-content -->
                              </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                       {{ Form::close()}}
                     </div>

                      {{-- Div de mensagem de carregamento--}}
                      <div id="Carregando" style="display: none;" class="jquery-waiting-base-container">Carregando...</div>
                     
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
