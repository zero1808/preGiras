@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->level == 1)

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Asignar evento a equipo</div>
                @if(isset($messages))
                <div class="alert alert-success">
                    <strong>{{$messages}}</strong>
                </div>   
                @endif
                @if(isset($onSuccessMessage))
                <div class="alert alert-success">
                    <strong>{{$onSuccessMessage}}</strong>
                </div>   
                @endif        
                @if(isset($error))
                <div class="alert alert-danger">
                    <strong>{{$error}}</strong>
                </div>   
                @endif
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Men&uacute;</th>
                                    </thead>
                                    <tbody>
                                        @if(isset($equipos))
                                        @foreach($equipos  as $equipo)
                                        <tr><td>{{$equipo->id}}</td>
                                            <td>{{$equipo->nombre}}</td>
                                            <td> 
                                                <button type="button" 
                                                        class="btn btn-success" 
                                                        data-toggle="modal" 
                                                        data-id="{{$equipo->id}}"
                                                        data-title="Asignacion de equipo: {{$equipo->nombre}}"
                                                        data-target="#asignEvent">Evento &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
                                                <br>&nbsp;
                                                <form action="{{URL::to('borrar/equipo/'.$equipo->id)}}" method="GET">{{ csrf_field() }}
                                                    <button class="btn btn-danger" title="Borrar equipo" data-toggle="tooltip">Borrar &nbsp;&nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i></button></form>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="asignEvent" 
         tabindex="-1" role="dialog" 
         aria-labelledby="asignEventLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                        id="changeTeamLabel">Asignaci&oacute;n de evento</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'orders.store', 'method'=>'POST']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" id="idTeam" name="idTeam">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="evento">Elige el evento a asignar:</label>
                                <select id="evento" class="form-control" name="evento" required="true">
                                </select>
                            </div>


                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                        </div>

                        <div class="col-sm-4">
                            {!! Form::submit('Asignar',['class' => 'btn btn-success'])!!}
                            {!! Form::close() !!}
                            <span class="pull-right"></span>
                            &nbsp;

                            <button type="button" 
                                    class="btn btn-default" 
                                    data-dismiss="modal">Cerrar</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    @endif
</div>
{{Html::script('js/jquery.js')}}
{{Html::script('js/jquery.min.js')}}
<script>var path = "{{URL::to('/')}}"</script>
<script>
    $(function () {
        $('#asignEvent').on("show.bs.modal", function (e) {
            $("#infoEventLabel").html($(e.relatedTarget).data('title'));
            $("#fav-title").html($(e.relatedTarget).data('title'));
            $("#idTeam").val($(e.relatedTarget).data('id'));
            $.ajax({
                type: 'GET',
                url: path + '/findEventsByTeam/' + $('#idTeam').val().trim() + '',
                success: function (r) {

                    if (r.status != false) {
                        $("#evento").html('');
                        var i = 0;
                        for (i = 0; i < r.eventos.length; i++) {
                            $("#evento").append('<option value="' + r.eventos[i].id + '">' + r.eventos[i].nombre + '</option>');
                        }

                    } else {
                        $("#evento").html('');
                        alert("No existen eventos disponibles");

                        $('#asignEvent').modal('hide');
                        return false;

                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }

            });


        });
    });
</script>
@endsection


