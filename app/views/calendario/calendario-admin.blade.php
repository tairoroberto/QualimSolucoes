<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta charset="utf-8" />
    <title>Qualim | Soluções</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta content="" name="description" />
    <meta content="" name="author" />

    <link href="packages/assets/plugins/pace/pace-theme-flash.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="packages/assets/plugins/fullcalendar/fullcalendar.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="packages/assets/plugins/jquery-slider/css/jquery.sidr.light.css" rel="stylesheet" type="text/css" media="screen"/>
    <link href="packages/assets/plugins/boostrap-checkbox/css/bootstrap-checkbox.css" rel="stylesheet" type="text/css" media="screen"/>
    <!-- BEGIN CORE CSS FRAMEWORK -->
    <link href="packages/assets/plugins/boostrapv3/css/bootstrap.min.css" rel="stylesheet" type="text/css"/>
    <link href="packages/assets/plugins/boostrapv3/css/bootstrap-theme.min.css" rel="stylesheet" type="text/css"/>
    <link href="packages/assets/plugins/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css"/>
    <link href="packages/assets/css/animate.min.css" rel="stylesheet" type="text/css"/>
    <!-- END CORE CSS FRAMEWORK -->
    <!-- BEGIN CSS TEMPLATE -->
    <link href="packages/assets/css/style.css" rel="stylesheet" type="text/css"/>
    <link href="packages/assets/css/responsive.css" rel="stylesheet" type="text/css"/>
    <link href="packages/assets/css/custom-icon-set.css" rel="stylesheet" type="text/css"/>

    <script src="packages/assets/plugins/jquery-1.8.3.min.js" type="text/javascript"></script>
    <!-- END CSS TEMPLATE -->

    <link rel="stylesheet" href="packages/assets/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css"/>


    <script>
        var stringDate;

        $(document).ready(function() {
            var date = new Date();
            var d = date.getDate();
            var m = date.getMonth();
            var y = date.getFullYear();
            var idusuario = "{{Auth::user()->get()->id}}";

            var calendar = $('#calendar').fullCalendar({
                editable: true,
                header: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'month,agendaWeek,agendaDay'
                },
                monthNames: ['Janeiro','Fevereiro','Março','Abril','Maio','Junho','Julho','Agosto','Setembro','Outubro','Novembro','Dezembro'],
                monthNamesShort: ['Jan','Fev','Mar','Abr','Mai','Jun','Jul','Ago','Set','Out','Nov','Dez'],
                dayNames: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                dayNamesShort: ['Domingo','Segunda','Terça','Quarta','Quinta','Sexta','Sábado'],
                buttonText: {
                    prev: '&nbsp;&#9668;&nbsp;',
                    next: '&nbsp;&#9658;&nbsp;',
                    prevYear: '&nbsp;&lt;&lt;&nbsp;',
                    nextYear: '&nbsp;&gt;&gt;&nbsp;',
                    today: 'hoje',
                    month: 'mês',
                    week: 'semana',
                    day: 'dia'
                },
                titleFormat: {
                    month: 'MMMM yyyy',
                    week: "d [ yyyy]{ '&#8212;'[ MMM] d MMM yyyy}",
                    day: 'dddd, d MMM, yyyy' },
                columnFormat: { month: 'ddd', week: 'ddd d/M', day: 'dddd d/M' },
                allDayText: 'dia todo', axisFormat: 'H:mm',
                timeFormat: {   '': 'H(:mm)',   agenda: 'H:mm{ - H:mm}' },

                events: "{{action('CalendarioController@mostrar',Auth::user()->get()->id)}}",

                // Convert the allDay from string to boolean
                eventRender: function(event, element, view) {
                    if (event.allDay === 'true') {
                        event.allDay = true;
                    } else {
                        event.allDay = false;
                    }
                },
                selectable: true,
                selectHelper: true,
                select: function(start, end, allDay) {



                    $("#start").val($.fullCalendar.formatDate(start, "dd-MM-yyyy HH:mm:ss"));
                    $("#end").val($.fullCalendar.formatDate(end, "dd-MM-yyyy HH:mm:ss"));
                    stringDate = $.fullCalendar.formatDate(start, "dd-MM-yyyy HH:mm:ss");
                    $('#myModal').modal('show');


                },

                editable: true,
                eventDrop: function(event, delta) {
                    var start = $.fullCalendar.formatDate(event.start, "dd-MM-yyyy HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "dd-MM-yyyy HH:mm:ss");
                    $.ajax({
                        url: "{{action('CalendarioController@atualizar')}}",
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&nutricionista_id='+idusuario+'&id='+ event.id,
                        type: "POST",
                        success: function(json) {
                            alert("Atualizado com sucesso");
                        }
                    });
                },
                eventResize: function(event) {
                    var start = $.fullCalendar.formatDate(event.start, "dd-MM-yyyy HH:mm:ss");
                    var end = $.fullCalendar.formatDate(event.end, "dd-MM-yyyy HH:mm:ss");
                    $.ajax({
                        url: "{{action('CalendarioController@atualizar')}}",
                        data: 'title='+ event.title+'&start='+ start +'&end='+ end +'&nutricionista_id='+idusuario+'&id='+ event.id,
                        type: "POST",
                        success: function(json) {
                            alert("Atualizado com sucesso");
                        }
                    });

                },

                eventClick: function(event) {
                    var decision = confirm("Deseja excluir este evento?");
                    if (decision) {
                        $.ajax({
                            type: "POST",
                            url: "{{action('CalendarioController@delete')}}",

                            data: "id=" + event.id
                        });
                        $('#calendar').fullCalendar('removeEvents', event.id);

                    } else {
                    }
                }

            });

        });


        function salvaCalendario(){
            var idusuario = "{{Auth::user()->get()->id}}";
            var title = $('#title').val();
            var description = $('#description').val();
            var location = $('#location').val();

            //pega o valor da data selecionada no calendario
            var start = $('#start').val();
            var end = $('#end').val();


            //verifica se a data é igual a do calendario sem o horario e se a data esta nula
            if(location == ""){
                erro("Preencha o campo Local/Cliente!");
                $('#location').focus();
                return;

            }else if(description == ""){
                erro("Preencha o campo Descrição!");
                $('#description').focus();
                return;

            }else if(start == stringDate || start == "" || start.length < 19){
                erro("Preencha o horário de entrada completamente!");
                $('#start').focus();
                return;

            }else if(end == stringDate || end == "" || end.length < 19){
                erro("Preencha o horário de saída completamente!");
                $('#end').focus();
                return;
            }


            if (description && location) {
                $.ajax({
                    url: "{{action('CalendarioController@store')}}",
                    data: 'title='+ title+'&start='+ start +'&end='+ end +'&nutricionista_id='+ idusuario+'&description='+ description+'&location='+ location ,
                    type: "POST",
                    success: function(json) {
                        //Mensagem de alerta quendo evento for adicionado alert('Evento adicionado com sucesso');
                    }
                });

                //renderiza o calendario depois de ter salva a data
                $('#calendar').fullCalendar('renderEvent',
                    {
                        title: title,
                        start: start,
                        end: end,
                        allDay: false
                    },
                    true // make the event "stick"
                );
            }

            //esconde o modal
            $("#myModal").modal("hide");

            $('#description').val("");
            $('#location').val("");
            $('#start').val("");
            $('#end').val("");

            formCalendario.action = "{{action('CalendarioController@create')}}";
            formCalendario.method = "GET";
            formCalendario.submit();

        }

        function erro(msg){
            $("#divErro").css("display","block");
            $("#msgErro").html(msg);
            return;
        }

    </script>



    <script type="text/javascript">
        $(function() {
            $('#datetimepicker1').datetimepicker({
                language: 'pt-BR'
            });

            $('#datetimepicker2').datetimepicker({
                language: 'pt-BR'
            });

            $("#start").mask("99-99-9999 99:99:00");
            $("#end").mask("99-99-9999 99:99:00");
        });
    </script>

</head>
<!-- END HEAD -->

<!-- BEGIN BODY -->
<body class="">


@include('layout.sidebar')

<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
<div id="portlet-config" class="modal hide">
    <div class="modal-header">
        <button data-dismiss="modal" class="close" type="button"></button>
        <h3>Widget Settings</h3>
    </div>
    <div class="modal-body"> Widget settings form goes here </div>
</div>
<div class="clearfix"></div>

<div class="content">
    <div class="col-md-12 tiles white ">
        <div class="tiles-body" >
            <div class="full-calender-header">

                <div class="clearfix"></div>
            </div>
            <div id='calendar'></div>
        </div>
    </div>
</div>
</div>

{{Form::open(array('id' => 'formCalendario'))}}
{{--Modal calendar start--}}
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Preencha os campos para cadastrar novo evento</h4>
            </div>
            <div class="alert" style="display: none;" id="divErro">
                <span class="label label-danger" id="msgErro"></span>
            </div>
            <div class="content">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label for="location" class="col-sm-2">Local/Cliente</label>
                        <input type="text" name="location" id="location" class="form-control" value="" title="Local/Cliente" required="required" >
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label for="title" class="col-sm-2">Título</label>
                        <input type="text" name="title" id="title" class="form-control" value="" title="Título" required="required" >
                    </div>

                    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                        <label for="title" class="col-sm-2">Descrição</label>
                        <input type="text" name="description" id="description" class="form-control" value="" title="Descrição" required="required" >
                    </div>


                    <br><br><br><br><br>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="datetimepicker1"> Hora de entrada</label>
                            <div id="datetimepicker1" class="input-append date">
                                <input data-format="dd-MM-yyyy hh:mm:ss" type='text' id="start" name="start" class="form-control" placeholder="Hora de entrada"/>
                                        <span class="add-on">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group">
                            <label for="datetimepicker2"> Hora de saída</label>
                            <div id="datetimepicker2" class="input-append date">
                                <input data-format="dd-MM-yyyy hh:mm:ss" type='text' id="end" name="end" class="form-control" placeholder="Hora de saída"/>
                                        <span class="add-on">
                                            <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
            <br><br><br><br><br><br><br><br><br>
            <div class="modal-footer">
                <button type="button" id="btnSalvar" class="btn btn-primary"  onclick="salvaCalendario();">Salvar</button>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
{{--Modal calendar end--}}

{{Form::close()}}



</div>

<!-- BEGIN CORE JS FRAMEWORK-->


<script type="text/javascript" src="packages/assets/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
<script type="text/javascript" src="packages/assets/plugins/jquery-mask/jquery.mask.js"></script>
<script src="packages/assets/plugins/jquery-ui/jquery-ui-1.10.1.custom.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/breakpoints.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-unveil/jquery.unveil.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-block-ui/jqueryblockui.js" type="text/javascript"></script>
<!-- END CORE JS FRAMEWORK -->
<!-- BEGIN PAGE LEVEL JS -->
<script src="packages/assets/plugins/pace/pace.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slider/jquery.sidr.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-numberAnimate/jquery.animateNumbers.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/jquery-ui-touch/jquery.ui.touch-punch.min.js" type="text/javascript"></script>
<script src="packages/assets/plugins/fullcalendar/fullcalendar.min.js"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- PAGE JS -->


<!-- BEGIN CORE TEMPLATE JS -->
<script src="packages/assets/js/core.js" type="text/javascript"></script>
<script src="packages/assets/js/chat.js" type="text/javascript"></script>
<script src="packages/assets/js/demo.js" type="text/javascript"></script>
<!-- END CORE TEMPLATE JS -->
</body>
</html>