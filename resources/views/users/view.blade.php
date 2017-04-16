@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->level == 1)

    <div class="row">
        <div class="col-md-12 col-md-offset-0">
            <div class="panel panel-default">
                <div class="panel-heading">Administrar usuarios</div>
                @if(isset($messages))
                <div class="alert alert-success">
                    <strong>{{$messages}}</strong>
                </div>   
                <br>
                @endif
                @if(isset($successMessage))
                <div class="alert alert-info">
                    <strong>{{$successMessage}}</strong>
                </div>   
                <br>
                @endif
                @if(isset($error))
                <div class="alert alert-danger">
                    <strong>{{$error}}</strong>
                </div>   
                <br>
                @endif
                <div class="panel-body">

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="table-responsive">
                                <table id="datatable" class="table">
                                    <thead>
                                    <th>ID</th>
                                    <th>Email</th>
                                    <th>Privilegio</th>
                                    <th>Fecha de creaci&oacute;n</th>
                                    <th>Nombre</th>
                                    <th>Municipio</th>
                                    <th>Equipo</th>
                                    <th>Men&uacute;</th>

                                    </thead>
                                    <tbody>
                                        @if(isset($usuarios))
                                        @foreach($usuarios  as $usuario)
                                        <tr><td>{{$usuario->id}}</td>
                                            <td>{{$usuario->email}}</td>
                                            <td>{{$usuario->level}}</td>
                                            <td>{{$usuario->created_at}}</td>
                                            @if(isset($usuario->profile))
                                            <td>{{$usuario->profile->name}}&nbsp;{{$usuario->profile->ap_paterno}}&nbsp;{{$usuario->profile->ap_materno}}</td>
                                            <td>{{$usuario->profile->municipality->name}}</td>
                                            @else
                                            <td>NA</td>
                                            <td>NA</td>                                                                                                                 
                                            @endif
                                            @if(isset($usuario->profile->team))
                                            <td>{{$usuario->profile->team->nombre}}</td>
                                            @else
                                            <td>NA</td>
                                            @endif                                                                                                               
                                            <td> 

                                                @if(isset($usuario->profile))
                                                <button type="button" 
                                                        class="btn btn-info" 
                                                        data-toggle="modal" 
                                                        data-id="{{$usuario->profile->id}}"
                                                        data-title="Asignacion de equipo: {{$usuario->profile->name}} &nbsp; {{$usuario->profile->ap_paterno}}&nbsp;{{$usuario->profile->ap_materno}}"
                                                        data-target="#changeTeam">Equipo &nbsp;<i class="fa fa-plus" aria-hidden="true"></i></button>
                                                @endif
                                                &nbsp;
                                                <form action="{{URL::to('borrar/usuario/'.$usuario->id)}}" method="GET">{{ csrf_field() }}
                                                    <button type="submit" class="btn btn-danger" title="Borrar usuario" data-toggle="tooltip">Borrar &nbsp;&nbsp;<i class="fa fa-times" aria-hidden="true"></i></button></form>

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
    <div class="modal fade" id="changeTeam" 
         tabindex="-1" role="dialog" 
         aria-labelledby="changeTeamLabel">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" 
                            data-dismiss="modal" 
                            aria-label="Close">
                        <span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" 
                        id="changeTeamLabel">Asignaci&oacute;n de equipo</h4>
                </div>
                <div class="modal-body">
                    {!! Form::open(['route' => 'profiles.team', 'method'=>'POST']) !!}
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <input type="hidden" id="idProfile" name="idProfile">

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            @if(isset($teams) && (count($teams)>0))
                            <div class="form-group">
                                <label for="equipoId">Elige el equipo:</label>
                                <select id="equipoId" class="form-control" name="equipoId" required="true">
                                    @foreach($teams as $team)
                                    <option value="{{$team->id}}">{{$team->nombre}}</option>
                                    @endforeach
                                </select>
                            </div>

                            @endif

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                        </div>

                        <div class="col-sm-4">
                            @if(isset($teams) && (count($teams)>0))
                            {!! Form::submit('Asignar',['class' => 'btn btn-success'])!!}
                            {!! Form::close() !!}
                            <span class="pull-right"></span>
                            &nbsp;
                            @endif   

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
<script>
    
$(document).ready(function(){
     var handleDataTableButtons = function () {
                if ($("#datatable-buttons").length) {
                    $("#datatable-buttons").DataTable({
                        dom: "Bfrtip",
                        buttons: [
                            {
                                extend: "copy",
                                className: "btn-sm"
                            },
                            {
                                extend: "csv",
                                className: "btn-sm"
                            },
                            {
                                extend: "excel",
                                className: "btn-sm"
                            },
                            {
                                extend: "pdfHtml5",
                                className: "btn-sm"
                            },
                            {
                                extend: "print",
                                className: "btn-sm"
                            },
                        ],
                        responsive: true
                    });
                }
            };

            TableManageButtons = function () {
                "use strict";
                return {
                    init: function () {
                        handleDataTableButtons();
                    }
                };
            }();

            $('#datatable').dataTable({
            "order": [ 0, 'asc' ],
            "language": {
            "url": "//cdn.datatables.net/plug-ins/9dcbecd42ad/i18n/Spanish.json"
                }

            });

            $('#datatable-keytable').DataTable({
                keys: true
            });

            $('#datatable-responsive').DataTable();

            $('#datatable-scroller').DataTable({
                ajax: "js/datatables/json/scroller-demo.json",
                deferRender: true,
                scrollY: 380,
                scrollCollapse: true,
                scroller: true
            });

            $('#datatable-fixed-header').DataTable({
                fixedHeader: true
            });

            var $datatable = $('#datatable-checkbox');

            $datatable.dataTable({
                'order': [[1, 'asc']],
                'columnDefs': [
                    {orderable: false, targets: [0]}
                ]
            });
            $datatable.on('draw.dt', function () {
                $('input').iCheck({
                    checkboxClass: 'icheckbox_flat-green'
                });
            });

            TableManageButtons.init();
});
$(function () {
        $('#changeTeam').on("show.bs.modal", function (e) {
            $("#changeTeamLabel").html($(e.relatedTarget).data('title'));
            $("#fav-title").html($(e.relatedTarget).data('title'));
            $("#idProfile").val($(e.relatedTarget).data('id'));
        });
    });
</script>
@endsection


