@extends('layout.layout')

  @section('head')
    @parent
    <script type="text/javascript">
        function chamaModal(id){
            $("#relatorio_id").val(id);
            $("#myModal").modal("show");
        }


        function enviar(action){
            if(action == "imprimir"){
                formRelatorioLista.action = "{{action('RelatorioController@imprimir')}}";
                formRelatorioLista.submit();

            }else if(action == "visualizar"){
                formRelatorioLista.action = "{{action('RelatorioController@visulaizar')}}";
                formRelatorioLista.submit();
            }else if(action == "editar"){
                formRelatorioLista.action = "{{action('RelatorioController@edit')}}";
                formRelatorioLista.submit();
            }else{
                formRelatorioLista.action = "{{action('RelatorioController@reenviarEmails')}}";
                formRelatorioLista.submit();
            }
            return;
        }
    </script>
  @stop
   
    @section('content')

    
        <!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <div class="clearfix"></div>
        <div class="content">
          <div class="row-fluid">
         {{Form::open(array('id'=>'formRelatorioLista','url'=>'relatorio-imprimir'))}}

          <div class="page-title"> 
        <h3><span class="semi-bold">Lista de visitas Técnicas</span></h3>
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
                        <th style="width:1%">Ação</th>
                        <th style="width:25%">Consultora</th>
                        <th style="width:30%">Cliente</th>
                        <th style="width:15%">Data</th>
                        <th style="width:15%">Início</th>
                        <th style="width:15%">Término</th>
                        <th style="width:20%">Duração</th>
                        <th style="width:20%">Situação</th>
                        
                      </tr>

                    </thead>
                    <tbody>
                     
                       @foreach ($relatorio_visitas as $relatorio_visita) 

                          <?php $nutricionista = Nutricionista::withTrashed()->find($relatorio_visita->nutricionista_id); ?>
                          <?php $cliente = Cliente::find($relatorio_visita->cliente_id); ?>
                          {{--Converte a data para ser mostrada--}}
                            <?php $data = explode(" ", $relatorio_visita->created_at) ?>
                          <?php $data = explode("-", $data[0]) ?>    
                          <tr >
                             <td onclick="chamaModal({{$relatorio_visita->id}})">
                               <a href="#">
                                <i class="fa fa-paste"> 
                                </i>                                      
                                </a>  
                              </td>
                              <td class="v-align-middle">{{$nutricionista->name}}</td>
                              <td class="v-align-middle">{{$cliente->razaoSocial}}</td>
                              <td class="v-align-middle">{{$data[2]."/".$data[1]."/".$data[0]}}</td>
                              <td class="v-align-middle">{{$relatorio_visita->hora_inicio}}</td>
                              <td class="v-align-middle">{{$relatorio_visita->hora_fim}}</td>
                              <td class="v-align-middle">{{$relatorio_visita->hora_total}}</td>
                              <td class="v-align-middle">
                                  @if($relatorio_visita->lido == 1)
                                      {{"Visualizado"}}
                                      @else
                                      {{"Não visualizado"}}
                                  @endif
                              </td>
                           </tr>
                         @endforeach                    
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>

              <div class="modal modal-wide fade" id="myModal">
                  <div class="modal-dialog">
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                              <h4 class="modal-title">Selecione uma ação para o relatório</h4>
                          </div>
                          <div class="modal-body" align="center">
                              {{--Start modal body--}}
                              <div class="row column-seperation">
                                  <div class="col-md-12">
                                      <div class="row form-row">
                                          <input type="hidden" id="relatorio_id" name="relatorio_id">
                                      </div>
                                  </div>
                              </div>
                              {{--End modal body--}}
                          </div>
                          <div class="modal-footer" style="text-align: center">
                              <button type="button" id="btnBuscarDados" class="btn btn-primary"  data-dismiss="modal" onclick="enviar('imprimir');">Imprimir</button>
                              <button type="button" id="btnVizualizar" class="btn btn-primary"  data-dismiss="modal" onclick="enviar('visualizar');">Vizualizar</button>
                              @if(Auth::user()->check())
                                  <button type="button" id="btnEditar" class="btn btn-primary"  data-dismiss="modal" onclick="enviar('editar');">Editar</button>
                                  <button type="button" id="btnRenviarEmails" class="btn btn-primary"  data-dismiss="modal" onclick="enviar('reenviar-emails');">Reenviar emails</button>
                              @endif
                              <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
                          </div>
                      </div><!-- /.modal-content -->
                  </div><!-- /.modal-dialog -->
              </div><!-- /.modal -->



            {{Form::close()}}
          </div>
        </div>
      </div>
      <h3>&nbsp;</h3>
    </div>
  </div>

    @stop    