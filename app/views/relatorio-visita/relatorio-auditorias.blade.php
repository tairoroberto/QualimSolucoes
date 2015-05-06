@extends('layout.layout')

@section('head')
  @parent
   <script type="text/javascript">
  $(document).ready(function () {
              
             $('#data-inicio').datepicker({
                    format: "dd/mm/yyyy"
                });
             $('#data-fim').datepicker({
                    format: "dd/mm/yyyy"
                });
            
            });


    $(function(){
      $('.textarea').htmlarea(); //$('.textarea').wysihtml5();
    });


</script>

      
@stop

@section('content')
  <div class="clearfix"></div>
   <div class="content">  
    <div class="page-title"> 
        <h3>Gerar <span class="semi-bold">Relatórios</span></h3>
    </div>
      
      {{Form::open(array('id'=>'formRelatorio', 'method'=>'post', 'url'=>'gerar-relatorio'))}}
      
          <div class="col-md-12">
             <textarea class="textarea" style="width: 100%; height: 400px" name="DoForo" id="DoForo"  rows="6" class="col-lg-12"></textarea>                              
          </div>
      {{Form::close()}}
  </div>
@stop