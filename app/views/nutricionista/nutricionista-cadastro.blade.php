@extends('layout.layout')

@section('head')
  @parent
  <script type="text/javascript">
   jQuery(function(){
   $("#telefone").mask("(99) 9999-9999");
   $("#celular").mask("(99) 9999-99999");
   $("#cep").mask("99.999-999");
});

   $(document).ready(function(){
    $('input[type=file]').bootstrapFileInput();
  });


   /********************************************************************************************/
   /*                           Função para a busca de CEP do Responsável                       */
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

   function changeColor(){
       $('#color').css("backgroundColor",  $('#color').val());
   }
  </script>
@stop

@section('content')
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Cadastro - <span class="semi-bold">Consultoras</span></h3>
              </div>
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-24">

                @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                            {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                        </ul>
                  </div>
                @endif
                

                  <div class="grid simple">
                
                    <div class="grid-body no-border">
                    {{Form::open(array('action' => 'NutricionistasController@store', 'files' => 'true'))}}
                   
                      <div class="row column-seperation">
                        <div class="col-md-24">
                         <p></p> <p></p>
                         <div class="row form-row">

                      <div class="col-md-6">
                          <input name="nome" id="nome" type="text"  class="form-control" placeholder="Nome" value="{{Input::old('nome')}}">  
                      </div>
                      <div class="col-md-3">

                        <input name="senha" id="senha" type="password"  class="form-control" placeholder="Senha" value="{{Input::old('senha')}}">
                      </div>
                      <div class="col-md-3">
                        <input name="senha_confirmation" id="senha_confirmation" type="password"  class="form-control" placeholder="Confirma Senha" value="{{Input::old('senha_confirmation')}}">
                      </div>
                    </div>

                    <div class="row form-row">

                        <div class="col-md-3">
                            <input name="cep" id="cep" type="text"  class="form-control" placeholder="CEP " value="{{Input::old('cep')}}"
                                onblur="buscarCep()" >
                        </div>
                        <div class="col-md-5">
                            <input name="bairro" id="bairro" type="text"  class="form-control" placeholder="Bairro" value="{{Input::old('bairro')}}">
                        </div>

                        <div class="col-md-4">
                            <input name="cidade" id="cidade" type="text"  class="form-control" placeholder="Municipio " value="{{Input::old('cidade')}}">
                        </div>

                    </div>
                    
                    
                    <div class="row form-row">                      
                      <div class="col-md-12">
                        <input name="endereco" id="endereco" type="text"  class="form-control" placeholder="Endereço " value="{{Input::old('endereco')}}">
                      </div>
                    </div>


                    <div class="row form-row"> 
                     <div class="col-md-2">
                        <input name="numero" id="numero" type="text"  class="form-control" placeholder="Numero " value="{{Input::old('numero')}}">
                      </div>                    
                      <div class="col-md-10">
                        <input name=" complemento" id=" complemento" type="text"  class="form-control" placeholder="Complemento " value="{{Input::old(' complemento')}}">
                      </div>                      
                    </div>

                    
                    <div class="row form-row">
                      <div class="col-md-3">
 
                          <input name="telefone" id="telefone" type="text"  class="form-control" placeholder="Telefone" value="{{Input::old('telefone')}}">   
                      </div>
                     <div class="col-md-3">

                        <input name="celular" id="celular" type="text"  class="form-control" placeholder="Celular " value="{{Input::old('celular')}}">
                      </div>

                      <div class="col-md-6">

                        <input name="email" id="email" type="text"  class="form-control" placeholder="E-mail " value="{{Input::old('email')}}">
                      </div>

                       <div class="col-md-3">
                        <select name="tipo" id="tipo" class="form-control" required="required" >
                        <option value="">Tipo de Usuário</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Consultora">Consultora</option>
                        <option value="Supervisora">Supervisora</option>
                      </select>
                     
                      </div>

                      <div class="col-md-2">
                        <select name="ticket" id="ticket" class="form-control" required="required" >
                        <option value="">Tickets permitidos</option>
                           @for ($i = 0; $i <= 31 ; $i++)
                             <option value="{{$i}}">{{$i}}</option>
                           @endfor
                      </select>
                     
                      </div>


                      <div class="col-md-3" id="DivFoto">
                          <input name="foto" id="foto" type="file" accept="image/*" class="filestyle btn btn-primary btn-cons" title="Selecione uma foto para o perfil" />
                      </div>   

                      <div class="col-md-3" id="DivAssinatura">
                          <input name="assinatura" id="assinatura" type="file" accept="image/*" class="filestyle btn btn-primary btn-cons" title="Selecione uma assinatura digital para o perfil" />
                      </div>                   


                    </div>
                      
                    
                    
                    <div class="row form-row">
                      
                      
                     
                    </div>
               </div>
   
                       
                            </div>
                          </div>
                        </div>
                      </div>
                      </div>
                      <div class="form-actions">
                        <div class="pull-left">
                            <label class="" for="color">Cor do Cronograma</label>
                            <input type="color" onchange="changeColor();" class="btn" name="color" id="color" style="float: left; width: 100px" title="Cor Para Cronograma" value="#3A87AD">
                        </div>
                        <div class="pull-right">
                            <br>
                          <button class="btn btn-primary btn-cons" type="submit">Salvar </button>
                          
                          <button class="btn btn-danger btn-cons" type="reset">Cancelar</button>
                        </div>
                      </div>
                  {{Form::close()}}
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
