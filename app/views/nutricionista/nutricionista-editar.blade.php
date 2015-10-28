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

  function escondeFoto(){
    if($('#tipo').val() == "Cliente"){
        document.getElementById("DivFoto").style.display = "none"; 
      }else{
        document.getElementById("DivFoto").style.display = "block";  
      }        
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
                <h3>Editar - <span class="semi-bold">Consultora</span></h3>
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
                    {{Form::open(array('url' => '/atualizar-usuario', 'files' => 'true'))}}
                   
                      <div class="row column-seperation">
                        <div class="col-md-24">
                         <p></p> <p></p>
                         <div class="row form-row">

                      <div class="col-md-6">
                          <input name="nome" id="nome" type="text"  class="form-control" placeholder="Nome" value="<?php if (isset($nutricionista->name)){echo $nutricionista->name;}elseif (Input::old("nome")){
                            echo Input::old("nome");
                          }?>">  
                      </div>
                      <div class="col-md-3">

                        <input name="senha" id="senha" type="password"  class="form-control" placeholder="Senha" value="<?php if (isset($nutricionista->password)){echo $nutricionista->password;}elseif (Input::old("senha")){
                            echo Input::old("senha");
                          }?>">
                      </div>
                      <div class="col-md-3">
                        <input name="senha_confirmation" id="senha_confirmation" type="password"  class="form-control" placeholder="Confirma Senha" value="<?php if (isset($nutricionista->password_confirmation)){echo $nutricionista->password_confirmation;}elseif (Input::old("senha_confirmation")){
                            echo Input::old("senha_confirmation");
                          }?>">
                      </div>
                    </div>
                    
                    
                    
                    
                    <div class="row form-row">                      
                      <div class="col-md-12">
                        <input name="endereco" id="endereco" type="text"  class="form-control" placeholder="Endereço " value="<?php if (isset($nutricionista->address)){echo $nutricionista->address;}elseif (Input::old("endereco")){
                            echo Input::old("endereco");
                          }?>">
                      </div>
                    </div>

                    <div class="row form-row"> 
                     <div class="col-md-2">
                        <input name="numero" id="numero" type="text"  class="form-control" placeholder="Numero " value="<?php if (isset($nutricionista->number)){echo $nutricionista->number;}elseif (Input::old("numero")){
                            echo Input::old("numero");
                          }?>">
                      </div>                     
                      <div class="col-md-10">
                        <input name="complemento" id="complemento" type="text"  class="form-control" placeholder="Complemento " value="<?php if (isset($nutricionista->complement)){echo $nutricionista->complement;}elseif (Input::old("complemento")){
                            echo Input::old("complemento");
                          }?>">
                      </div>                      
                    </div>


                    
                    <div class="row form-row">
                      <div class="col-md-5">
 

                          <input name="bairro" id="bairro" type="text"  class="form-control" placeholder="Bairro" value="<?php if (isset($nutricionista->district)){echo $nutricionista->district;}elseif (Input::old("bairro")){
                            echo Input::old("bairro");
                          }?>">   
                      </div>
                      <div class="col-md-4">

                        <input name="cidade" id="cidade" type="text"  class="form-control" placeholder="Municipio " value="<?php if (isset($nutricionista->city)){echo $nutricionista->city;}elseif (Input::old("cidade")){
                            echo Input::old("cidade");
                          }?>">
                      </div>
                      <div class="col-md-3">

                        <input name="cep" id="cep" type="text"  class="form-control" placeholder="CEP " value="<?php if (isset($nutricionista->postal_code)){echo $nutricionista->postal_code;}elseif (Input::old("cep")){
                            echo Input::old("cep");
                          }?>">
                      </div>
                    </div>
                    
                    <div class="row form-row">
                      <div class="col-md-3">
 
                          <input name="telefone" id="telefone" type="text"  class="form-control" placeholder="Telefone" value="<?php if (isset($nutricionista->telephone)){echo $nutricionista->telephone;}elseif (Input::old("telefone")){
                            echo Input::old("telefone");
                          }?>">   
                      </div>
                     <div class="col-md-3">

                        <input name="celular" id="celular" type="text"  class="form-control" placeholder="Celular " value="<?php if (isset($nutricionista->celphone)){echo $nutricionista->celphone;}elseif (Input::old("celular")){
                            echo Input::old("celular");
                          }?>">
                      </div>

                      <div class="col-md-6">

                        <input name="email" id="email" type="text"  class="form-control" placeholder="E-mail " value="<?php if (isset($nutricionista->email)){echo $nutricionista->email;}elseif (Input::old("email")){
                            echo Input::old("email");
                          }?>">
                      </div>

                       <div class="col-md-3">
                        <select name="tipo" id="tipo" class="form-control" required="required" onchange="escondeFoto();">
                        <option value="">Tipo de Usuário</option>
                        <option value="Administrador">Administrador</option>
                        <option value="Consultora">Consultora</option>
                        <option value="Supervisora">Supervisora</option>
                      </select>
                     
                      </div>


                       <div class="col-md-2">
                        <select name="ticket" id="ticket" class="form-control" required="required" >
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
                    <input type="hidden" id="nutricionista_id" name="nutricionista_id" value="<?php if (isset($nutricionista->id)){echo $nutricionista->id;}elseif (Input::old("nutricionista_id")){
                            echo Input::old("nutricionista_id");
                          }?>">
                      
                      
                     
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
                              <input onchange="changeColor();" type="color" class="btn" name="color" id="color" style="float: left; width: 100px; background-color: <?php if (isset($nutricionista->color)){echo $nutricionista->color;}elseif (Input::old("color")){
                                  echo Input::old("color");
                              }?>" title="Cor Para Cronograma" value="<?php if (isset($nutricionista->color)){echo $nutricionista->color;}elseif (Input::old("color")){
                                  echo Input::old("color");
                              }?>">
                          </div>
                          <br><br>
                        <div class="pull-right">
                          <button class="btn btn-primary btn-cons" type="submit">Salvar </button>
                          
                         <a href="<?php if (isset($nutricionista->id)){
                          echo action('NutricionistasController@delete',$nutricionista->id);}elseif (Input::old("nutricionista_id")){
                            echo action('NutricionistasController@delete',Input::old('nutricionista_id'));
                          }?>"> 
                            <button class="btn btn-danger btn-cons" type="button">Excluir</button>
                         </a>
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
