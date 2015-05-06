@extends('layout.layout')

@section('head')
  @parent
    <script type="text/javascript">
    function enviar(id,name,link){
      formLinks.NomeExibicao.value = name;
      formLinks.Url.value = link;
      formLinks.link_id.value = id;
    }

    function enviar2(action){
      if (action == "Editar") {        
        formLinks.action = "/atualiza-links";
        formLinks.submit();
      }else{
        formLinks.action = "/deletar-links";
        formLinks.submit();
      }
    }
    </script>
@stop

@section('content')
            <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
            <div class="clearfix"></div>
            <div class="content">
              <div class="page-title"> 
                <h3>Cadastro - <span class="semi-bold">Links</span></h3>
              </div>
              
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-12">
                  <div class="grid simple">
                    <div class="grid-title no-border"></div>
                    <div class="grid-body no-border">
                    <form class="form-no-horizontal-spacing" id="formLinks" name="formLinks" method="POST" action="{{action('LinksController@store')}}">
                      <div class="row column-seperation">
                        <div class="col-md-12">
                          <h4>Novo link</h4>

                           @if ($errors->any())
                              <div class="alert alert-danger">
                                  <ul>
                                        {{ implode('', $errors->all('<li class="error">:message</li>')) }}
                                    </ul>
                              </div>
                            @endif
                         
                          <div class="row form-row">
                            <div class="col-md-4">
                              <input name="NomeExibicao" id="NomeExibicao" type="text"  class="form-control" placeholder="Nome de exeibicão" value="{{Input::old('NomeExibicao')}}">
                              <input type="hidden" name="NomeExibicaoAux" id="NomeExibicaoAux">
                            </div>
                            <div class="col-md-8">
                              <input name="Url" id="Url" type="text"  class="form-control" placeholder="http://site.com.br" value="{{Input::old('Url')}}">
                              <input type="hidden" name="UrlAux" id="UrlAux">
                            </div>
                          </div>

                          <input type="hidden" name="link_id" id="link_id">
                         <div class="row form-row">
                            <div class="col-md-12">
                            <button class="btn btn-primary btn-cons" type="submit">Adicionar </button>
                            
                           
                           <button class="btn btn-primary btn-cons" type="button"
                              onclick="enviar2('Editar');">Editar</button>
                            <button class="btn btn-primary btn-cons" type="button"
                                onclick="enviar2('Excluir');">Excluir</button>
                           
                              
                            </div>
                          </div>
                         
                          
                        </div>
                        
                        
                </div>
              
            <!-- END FORM -->
              <!-- START FORM -->
              <div class="row">
                <div class="col-md-12">
                        <div class="grid simple ">
                            <div class="grid-title no-border">
                               
                            </div>
                            <div class="grid-body no-border">                           
                              <table class="table table-hover no-more-tables">
                                 <thead>
                                    <tr>
                                      <th style="width:1%"></th>
                                      <th style="width:20%">Nome</th>
                                      <th style="width:80%;">Url</th>                       
                                     </tr>
                                 </thead>
                                 <?php $links = Link::all(); ?>
                               <tbody>                      
                                  @foreach ($links as $link)
                                     <tr>
                                <td onclick="enviar('{{$link->id}}','{{$link->name}}','{{$link->url}}');">
                                        <a href="#">
                                          <i class="fa fa-paste">                                   
                                          </i>                                      
                                         </a>  
                                      </td>
                                      <td>{{$link->name}}</td>
                                      <td>{{$link->url}}</td>                 
                                    </tr> 
                                   @endforeach
                            </tbody>
                         </table>
                     </div>
                 </div>
              </div>
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