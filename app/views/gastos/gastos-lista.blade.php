@extends('layout.layout')
  @section('head')
    @parent
      <script type="text/javascript">
      function enviar(id){
        formUsuarioLista.nutricionista_id.value = id;
        formUsuarioLista.submit();
      }
      </script>
  @stop
   
    @section('content')
          {{-- expr --}}
    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">
          
          {{Form::open(array('url' => '/visualizar-gastos-mes','method' => 'post','id' =>'formUsuarioLista'))}}
          <div class="page-title"> 
        <h3>Lista de <span class="semi-bold">Despesas</span></h3>
      </div>
            <div class="span12">
              <div class="grid simple">
              
                <div class="grid-body">
                  <table class="table table-hover table-condensed" id="example">
                    <thead>
                      <tr>
                        <th style="width:1%"></th>
                        <th style="width:31%">Nome de Exibição</th>
                        <th style="width:30%">E-mail</th>
                        <th style="width:20%">Telefone</th>
                        <th style="width:19%">Tipo</th>
                        
                      </tr>

                    </thead>
                    <tbody>   
                       @foreach ($nutricionistas as $nutricionista)    
                          <tr >
                             <td onclick="enviar({{$nutricionista->id}});">
                               <a href="#">
                                <i class="fa fa-paste"> 
                                </i>                                      
                                </a>  
                              </td>
                              <td class="v-align-middle">{{$nutricionista->name}}</td>
                              <td class="v-align-middle">{{$nutricionista->email}}</td>
                              <td class="v-align-middle">{{$nutricionista->telephone}}</td>
                              <td class="v-align-middle">{{$nutricionista->type}}</td>
                           </tr>
                         @endforeach
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              <input type="hidden" name="nutricionista_id" id="nutricionista_id">

           {{Form::close()}}
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>
 @stop    