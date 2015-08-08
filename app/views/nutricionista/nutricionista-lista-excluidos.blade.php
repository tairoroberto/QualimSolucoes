@extends('layout.layout')

  @section('head')
    @parent
    <script type="text/javascript">
    function enviar(id){
      formNutricionistaLista.nutricionista_id.value = id;
      formNutricionistaLista.submit();
    }
    </script>
  @stop
   
    @section('content')
          {{-- expr --}}
    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">
          
          <div class="page-title"> 
            <h3><span class="semi-bold">Consultoras</span></h3>
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
              {{Form::open(array('id'=>'formNutricionistaLista','url'=>'editar-usuario'))}}
                
              <input type="hidden" id="nutricionista_id" name="nutricionista_id">
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:1%">Restaurar</th>
                        <th style="width:31%">Nome de Exibição</th>
                        <th style="width:30%">E-mail</th>
                        <th style="width:20%">Celular</th>
                        <th style="width:19%">Tipo</th>
                        
                      </tr>

                    </thead>
                    <tbody>   
                       @foreach ($nutricionistas as $nutricionista)   
                          <tr >
                             <td onclick="enviar({{$nutricionista->id}})">
                               <a href="{{action('NutricionistasController@restoreUser',$nutricionista->id);}}" title="Restaurar consultora">
                                <i class="fa fa-paste"> 
                                </i>                                      
                                </a>  
                              </td>
                              <td class="v-align-middle">{{$nutricionista->name}}</td>
                              <td class="v-align-middle">{{$nutricionista->email}}</td>
                              <td class="v-align-middle">{{$nutricionista->celphone}}</td>
                              <td class="v-align-middle">{{$nutricionista->type}}</td>
                           </tr>
                         @endforeach
	                    </tbody>
	                  </table>
	                </div>
	              </div>
	            </div>
              {{Form::close()}}
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>

    @stop    