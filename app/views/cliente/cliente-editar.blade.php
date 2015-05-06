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
    var user = $('#userselected').val();
    $('#nutricionista_id').multiselect('select', user);

    $('#nutricionista_id').multiselect({
               buttonWidth: '300px'
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
                    {{Form::open(array('id' => 'formClient','action' => 'ClienteController@atualizar', 'files' => 'true'))}}


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
                          <input name="razaoSocial" id="razaoSocial" type="text"  class="form-control" placeholder="Razão social" value="<?php if (isset($cliente->razaoSocial)){echo $cliente->razaoSocial;}elseif (Input::old("razaoSocial")){
                            echo Input::old("razaoSocial");
                          }?>">   
                      </div>

                      <div class="col-md-6">
                          <input name="nomeFantasia" id="nomeFantasia" type="text"  class="form-control" placeholder="Razão social" value="<?php if (isset($cliente->nomeFantasia)){echo $cliente->nomeFantasia;}elseif (Input::old("nomeFantasia")){
                            echo Input::old("nomeFantasia");
                          }?>">   
                      </div>
                      
                    
                     <div class="col-md-3">
                        <input name="cnpj" id="cnpj" type="text"  class="form-control" placeholder="CNPJ " value="<?php if (isset($cliente->cnpj)){echo $cliente->cnpj;}elseif (Input::old("cnpj")){
                            echo Input::old("cnpj");
                          }?>">
                      </div>
                      
                      <div class="col-md-6">
                        <input name="endereco" id="endereco" type="text"  class="form-control" placeholder="Endereço " value="<?php if (isset($cliente->address)){echo $cliente->address;}elseif (Input::old("endereco")){
                            echo Input::old("endereco");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="numero" id="numero" type="text"  class="form-control" placeholder="Numero " value="<?php if (isset($cliente->number)){echo $cliente->number;}elseif (Input::old("numero")){
                            echo Input::old("numero");
                          }?>">
                      </div>

                      <div class="col-md-2"> 
                          <input name="bairro" id="bairro" type="text"  class="form-control" placeholder="Bairro" value="<?php if (isset($cliente->district)){echo $cliente->district;}elseif (Input::old("bairro")){
                            echo Input::old("bairro");
                          }?>">   
                      </div>
                      <div class="col-md-10"> 
                          <input name="complemento" id="complemento" type="text"  class="form-control" placeholder="Complemento" value="<?php if (isset($cliente->complement)){echo $cliente->complement;}elseif (Input::old("complemento")){
                            echo Input::old("complemento");
                          }?>">   
                      </div>

                    </div>
                    
                    <div class="row form-row">
                   
                      <div class="col-md-5">
                        <input name="cidade" id="cidade" type="text"  class="form-control" placeholder="Municipio " value="<?php if (isset($cliente->city)){echo $cliente->city;}elseif (Input::old("cidade")){
                            echo Input::old("cidade");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="cep" id="cep" type="text"  class="form-control" placeholder="CEP " value="<?php if (isset($cliente->postal_code)){echo $cliente->postal_code;}elseif (Input::old("cep")){
                            echo Input::old("cep");
                          }?>" onblur="buscarCep()">
                      </div>

                          <div class="col-md-4"> 
                          <input name="telefone" id="telefone" type="text"  class="form-control" placeholder="Telefone empresa" value="<?php if (isset($cliente->telephone)){echo $cliente->telephone;}elseif (Input::old("telefone")){
                            echo Input::old("telefone");
                          }?>">   
                      </div>

                    </div>
                    
                    
                    <div class="row form-row">
                      
                      <div class="col-md-6">
                        <input name="contato" id="contato" type="text"  class="form-control" placeholder="Nome do contato " value="<?php if (isset($cliente->contact)){echo $cliente->contact;}elseif (Input::old("contato")){
                            echo Input::old("contato");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="telefone_contato" id="telefone_contato" type="text"  class="form-control" placeholder="Telefone do contato" value="<?php if (isset($cliente->telephone_contact)){echo $cliente->telephone_contact;}elseif (Input::old("telefone_contato")){
                            echo Input::old("telefone_contato");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="celular_contato" id="celular_contato" type="text"  class="form-control" placeholder="Celular do contato" value="<?php if (isset($cliente->celphone_contact)){echo $cliente->celphone_contact;}elseif (Input::old("celular_contato")){
                            echo Input::old("celular_contato");
                          }?>">
                      </div>

                     </div>

                     <div class="row form-row">
                      
                      <div class="col-md-8">
                        <input name="email_contato" id="email_contato" type="text"  class="form-control" placeholder="Email do contato " value="<?php if (isset($cliente->email_contact)){echo $cliente->email_contact;}elseif (Input::old("email_contato")){
                            echo Input::old("email_contato");
                          }?>">
                      </div>
                      <div class="col-md-4">               
                      {{-- ver select multiplo multiple--}}         
                        <select name="nutricionista_id[]" id="nutricionista_id" multiple class="form-control" required="required">
                        <?php 
                          $nutricionista_nome = "";

                          //get the array and find id's separated by ","
                          if (isset($cliente->nutricionista_id)) {
                            $nutricionista_idAux = explode(",",$cliente->nutricionista_id);
                            $i = 0;

                            //get id's and put in var $id
                            foreach ($nutricionista_idAux as $id) {
                               
                               //if var $id is not null, find the nutricionista
                               if ($id != "") {
                                 $nutricionista = Nutricionista::withTrashed()->find($id);
                                 $nutricionista_nome .= $nutricionista->name.",";
                               }                               
                            }
                            ?>  

                                <option value="{{$cliente->nutricionista_id}}">{{$nutricionista_nome}}</option>             
                        <?php  } ?>

                        <?php $nutricionistas = Nutricionista::all(); ?>
                        @foreach ($nutricionistas as $nutricionista1)
                          <option value="{{$nutricionista1->id}}">{{$nutricionista1->name}}</option>
                        @endforeach                       
                      </select>
                      <input type="hidden" name="userselected" id="userselected" value="{{$cliente->nutricionista_id}}">
                      </div>  



                      <div class="col-md-6">
                        <input name="email" id="email" type="text"  class="form-control" placeholder="E-mail empresa " value="<?php if (isset($cliente->email)){echo $cliente->email;}elseif (Input::old("email")){
                            echo Input::old("email");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="senha" id="senha" type="password"  class="form-control" placeholder="Senha " value="<?php if (isset($cliente->password)){echo $cliente->password;}elseif (Input::old("senha")){
                            echo Input::old("senha");
                          }?>">
                      </div>

                      <div class="col-md-3">
                        <input name="senha_confirmation" id="senha_confirmation" type="password"  class="form-control" placeholder="Confirma senha " value="<?php if (isset($cliente->password_confirmation)){echo $cliente->password_confirmation;}elseif (Input::old("senha_confirmation")){
                            echo Input::old("senha_confirmation");
                          }?>">
                      </div>

                      <?php if (isset($cliente->id)){
                         $emailClientes = EmailCliente::where('cliente_id','=',$cliente->id)->get();
                          foreach ($emailClientes as $emailCliente){?>
                            <div class='col-md-12'>
                                 <input name='emailArray[]' id='emailArray' type='text'  class='form-control' placeholder='E-mail da empresa' value="{{$emailCliente->email}}">
                                 <input type="hidden" name="idEmail[]" id="idEmail" value="{{$emailCliente->id}}">
                            </div>
                        <?php } 

                      }elseif (Input::old("emailArray")){
                            $emailCliente = Input::old("emailArray");
                            $idEmail = Input::old("idEmail");
                            $i = 0;
                            $j = 0;
                         
                          while (($i < count($emailCliente)) and ($j < count($idEmail))){ ?>
                            <div class='col-md-12'>
                                 <input name='emailArray' id='emailArray' type='text'  class='form-control' placeholder='E-mail da empresa' value="{{$emailCliente[$i]}}">
                                 <input type="hidden" name="idEmail[]" id="idEmail" value="{{$idEmail[$j]}}">
                            </div>
                        <?php 
                          $i++;
                          $j++;
                          }
                        } ?>
                      
                     </div>                    
                  </div>
                       
              </div>

                <input type="hidden" id="cliente_id" name="cliente_id" value="<?php if (isset($cliente->id)){echo $cliente->id;}elseif (Input::old("cliente_id")){
                            echo Input::old("cliente_id");
                          }?>">


                      <div class="form-actions">
                        <div class="pull-left">
                          <div class="pull-left col-md-5">
                              <input name="logo" id="logo" type="file" accept="image/*" class="filestyle btn btn-primary btn-cons" title="Selecione a logomarca do cliente" />
                            </div>
                        </div>
                        <div class="pull-right">
                          <button class="btn btn-primary btn-cons" type="submit">Salvar </button>
                          

                          <a href="<?php if (isset($cliente->id)){
                          echo action('ClienteController@delete',$cliente->id);}elseif (Input::old("cliente_id")){
                            echo action('ClienteController@delete',Input::old('cliente_id'));
                          }?>"> 
                          <button class="btn btn-danger btn-cons" type="button">Excluir</button>
                        </a>
                        </div>
                      </div>
                   {{ Form::close()}}
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
