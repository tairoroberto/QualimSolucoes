@extends('layout.layout')


    @section('content')

    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">
         {{Form::open(array('id'=>'formClienteLista','url'=>'editar-cliente'))}}
          <input type="hidden" id="cliente_id" name="cliente_id">
          <div class="page-title"> 
        <h3><span class="semi-bold">Clientes excluídos</span></h3>
      </div>

              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                      </ul>
                  </div>
              @endif

            <div class="span12">
              <div class="grid simple">
              
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:1%">Restaurar</th>
                        <th style="width:20%">Razão social</th>
                        <th style="width:20%">Nome Fantasia</th>
                        <th style="width:20%">usuário de login</th>
                        <th style="width:20%">Contato</th>
                        <th style="width:20%">Responsável</th>
                        
                      </tr>

                    </thead>
                    <tbody>
                       @foreach ($clientes as $cliente)
                        <?php $nutricionista = Nutricionista::withTrashed()->find($cliente->nutricionista_id); ?>
                          <tr>
                              <td>
                                <a href="{{action('ClienteController@restoreCliente',$cliente->id)}}" title="Restaurar Cliente">
                                  <i class="fa fa-paste">
                                  </i>                                      
                                 </a>  
                              </td>
                              <td class="v-align-middle">{{$cliente->razaoSocial}}</td>
                              <td class="v-align-middle">{{$cliente->nomeFantasia}}</td>
                              <td class="v-align-middle">{{$cliente->email}}</td>
                              <td class="v-align-middle">{{$cliente->contact}}</td>
                              <td class="v-align-middle">{{$nutricionista->name}}</td>
                           </tr>
                        @endforeach	                      
	                    </tbody>
	                  </table>
	                </div>
	              </div>
	            </div>

            </form>
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>

    @stop    