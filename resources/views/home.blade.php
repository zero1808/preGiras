<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        {{Html::style('css/nprogress.css')}}
        {{Html::style('css/animate.min.css')}}
        {{Html::style('css/font-awesome.min.css')}}
        {{Html::style('css/summernote.css')}}
        {{Html::style('clockpicker/dist/bootstrap-clockpicker.min.css')}}
        {{Html::style('css/dataTables.bootstrap.min.css')}}
        {{Html::style('css/buttons.bootstrap.min.css')}}
        {{Html::style('css/fixedHeader.bootstrap.min.css')}}        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!}
            ;
        </script>
    </head>
    <style>
        #map {
            height: 300px;
            width: 100%;
        }
        .popover {
            z-index: 215000000 !important;
        }
        .daterangepicker{
            z-index: 1100 !important;
        }
        /*#mdialTamanio{
            width: 50% !important;
        }*/
    </style>
    <style type="text/css">
        .btn-file {
            position: relative;
            overflow: hidden;
        }
        .btn-file input[type=file] {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 100%;
            min-height: 100%;
            font-size: 100px;
            text-align: right;
            filter: alpha(opacity=0);
            opacity: 0;
            outline: none;
            background: white;
            cursor: inherit;
            display: block;
        }
        /* The snackbar - position it at the bottom and in the middle of the screen */
        #snackbar {
            visibility: hidden; /* Hidden by default. Visible on click */
            min-width: 250px; /* Set a default minimum width */
            margin-left: -125px; /* Divide value of min-width by 2 */
            background-color: #2ab27b; /* Black background color */
            color: #fff; /* White text color */
            text-align: center; /* Centered text */
            border-radius: 2px; /* Rounded borders */
            padding: 16px; /* Padding */
            position: fixed; /* Sit on top of the screen */
            z-index: 1100 !important;
            left: 50%; /* Center the snackbar */
            bottom: 30px; /* 30px from the bottom */
        }

        /* Show the snackbar when clicking on a button (class added with JavaScript) */
        #snackbar.show {
            visibility: visible; /* Show the snackbar */

            /* Add animation: Take 0.5 seconds to fade in and out the snackbar. 
            However, delay the fade out process for 2.5 seconds */
            -webkit-animation: fadein 0.5s, fadeout 0.5s 2.5s;
            animation: fadein 0.5s, fadeout 0.5s 2.5s;
        }

        /* Animations to fade the snackbar in and out */
        @-webkit-keyframes fadein {
            from {bottom: 0; opacity: 0;} 
            to {bottom: 30px; opacity: 1;}
        }

        @keyframes fadein {
            from {bottom: 0; opacity: 0;}
            to {bottom: 30px; opacity: 1;}
        }

        @-webkit-keyframes fadeout {
            from {bottom: 30px; opacity: 1;} 
            to {bottom: 0; opacity: 0;}
        }

        @keyframes fadeout {
            from {bottom: 30px; opacity: 1;}
            to {bottom: 0; opacity: 0;}
        }
    </style>
    <body>
        <div id="app" >
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/home') }}">
                            {{ config('app.name', 'Laravel') }}
                        </a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Authentication Links -->

                            @if (Auth::guest())
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Registro</a></li>
                            @else
                            @if(Auth::user()->level ==2 && Auth::user()->profile)
                            <li class="dropdown">
                                <a href="{{url('/calendario')}}"  role="button" aria-expanded="false">
                                    Calendario
                                </a>
                            </li> 
                            <li class="dropdown">
                                <a href="{{url('/fullagenda')}}"  role="button" aria-expanded="false">
                                    Agenda definitiva
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->level ==3 && Auth::user()->profile)
                            <li class="dropdown">
                                <a href="{{url('/calendario')}}"  role="button" aria-expanded="false">
                                    Calendario
                                </a>
                            </li> 
                            <li class="dropdown">
                                <a href="{{url('/fullagenda')}}"  role="button" aria-expanded="false">
                                    Agenda definitiva
                                </a>
                            </li>
                            @endif
                            @if(Auth::user()->level ==1 && Auth::user()->profile)
                            <li class="dropdown">
                                <a href="{{url('/calendario')}}"  role="button" aria-expanded="false">
                                    Calendario
                                </a>
                            </li> 
                            <li class="dropdown">
                                <a href="{{url('/fullagenda')}}"  role="button" aria-expanded="false">
                                    Agenda definitiva
                                </a>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Men&uacute; <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/register') }}">Crear usuario</a></li>
                                    <li><a href="{{ url('/teams/create') }}">Crear equipo</a></li>
                                    <li><a href="{{ url('/events/create') }}">Crear evento</a></li>
                                    <li><a target="_blank" href="{{URL::to('/')}}/uploads/pdf/formatovacio.pdf">Descargar Formato</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Usuarios <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/users') }}">Administrar usuarios</a></li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    Equipos <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu">
                                    <li><a href="{{ url('/teams') }}">Asignar evento</a></li>
                                </ul>
                            </li>

                            @endif
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->email }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ route('logout') }}"
                                           onclick="event.preventDefault();
                                                   document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container">
                <div class="row">
                    <div class="col-sm-12 col-sm-offset-0">
                        <div class="panel panel-default">

                            <div class="panel-body">
                                <div class="panel-heading">Dashboard</div>
                                @if(isset($messages))
                                <div class="alert alert-success">
                                    <strong>{{$messages}}</strong>
                                </div>   
                                <br>
                                @endif
                                @if(Session::has('success'))
                                <div class="alert-box success">
                                    <h2>{!! Session::get('success') !!}</h2>
                                </div>
                                @endif
                                <p class="errors">{!!$errors->first('fotoslugar')!!}</p>
                                @if(Session::has('error'))
                                <p class="errors">{!! Session::get('error') !!}</p>
                                @endif
                                @if (isset($errors) && $errors->has(''))
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <strong>{{$error}}</strong>
                                    @endforeach
                                </div>   
                                @endif                      

                                @if(Auth::user()->level == 1)
                                @if(isset($eventos))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table id="datatable" class="table">
                                                <thead>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha del evento</th>
                                                <th>Municipio</th>
                                                <th>Responsable</th>
                                                <th>Equipo(s) asignado</th>
                                                <th>Barra de progreso de los datos</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody>
                                                    @if(isset($eventos))
                                                    @foreach($eventos  as $evento)
                                                    <tr><td>{{$evento->id}}</td>
                                                        <td>{{$evento->nombre}}</td>
                                                        <td>{{$evento->f_inicio}}</td>
                                                        <td>{{$evento->municipality->name}}</td>
                                                        @if($evento->profile!=NULL)
                                                        <td>{{$evento->profile->name}}&nbsp;{{$evento->profile->ap_paterno}}&nbsp;{{$evento->profile->ap_materno}}&nbsp;</td>
                                                        @else
                                                        <td>NA</td>
                                                        @endif
                                                        @if(isset($evento->orders))
                                                        <td>
                                                            @for ($i = 0; $i < count($evento->orders); $i++)

                                                            @for ($j = 0; $j < count($evento->orders[$i]->teams); $j++)
                                                            -{{$evento->orders[$i]->teams[$j]->nombre}}<br>
                                                            @endfor
                                                            @endfor
                                                        </td>
                                                        @endif

                                                        <td>
                                                            <?php $porcentaje_evento = 0; ?>
                                                            @if(isset($evento))
                                                            <?php $porcentaje_evento = 20; ?>
                                                            @if(isset($evento->information))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 20; ?>
                                                            @endif
                                                            @if(isset($evento->place))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 20; ?>
                                                            @endif
                                                            @if(isset($evento->program))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 4; ?>
                                                            @if(isset($evento->program->presidiummembers))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 4; ?>
                                                            @endif
                                                            @if(isset($evento->program->especialassistans))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 4; ?>
                                                            @endif
                                                            @if(isset($evento->program->dayorders))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 4; ?>
                                                            @endif
                                                            @if(isset($evento->program->firstlines))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 4; ?>
                                                            @endif
                                                            @if(isset($evento->logisticrequiriment))
                                                            <?php $porcentaje_evento = $porcentaje_evento + 20; ?>
                                                            @endif
                                                            @endif
                                                            @endif
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped active bg-danger" role="progressbar"
                                                                     aria-valuenow="{{$porcentaje_evento}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$porcentaje_evento}}%">
                                                                    {{$porcentaje_evento}}%
                                                                </div>
                                                            </div>
                                                        </td>

                                                        <td> 
                                                            <div class="btn-group">

                                                                <button type="button" 
                                                                        class="btn btn-info" 
                                                                        data-toggle="modal" 
                                                                        data-id="{{$evento->id}}"
                                                                        data-title="Evento: {{$evento->nombre}}"
                                                                        data-target="#infoEvent">Ver &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye" aria-hidden="true"></i></button>
                                                                <br><br>
                                                                <a href="{{URL::to('generarpdf/'.$evento->id)}}" target="_blank"><button  type="submit" class="btn btn-success" title="Descargar PDF">PDF &nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
                                                                <br><br>
                                                                <a href="{{URL::to('generarficha/'.$evento->id)}}" target="_blank"><button  type="submit" class="btn btn-default" title="PDF">Ficha &nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
                                                                <br><br>
                                                                <button type="button" class="btn btn-danger" data-toggle="modal" 
                                                                        data-id="{{$evento->id}}"
                                                                        data-title="Evento: {{$evento->nombre}}"
                                                                        data-target="#borrarEvento" title="Borrar evento" data-toggle="tooltip">Borrar <i class="fa fa-times" aria-hidden="true"></i></button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>

                                @endif
                                @endif
                                @if(Auth::user()->level == 2)
                                @if(isset($eventos_responsable))

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha del evento</th>
                                                <th>Objetivo</th>
                                                <th>Municipio</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody>
                                                    @if(isset($eventos_responsable))
                                                    @foreach($eventos_responsable  as $er)
                                                    <tr><td>{{$er->id}}</td>
                                                        <td>{{$er->nombre}}</td>
                                                        <td>{{$er->f_inicio}}</td>
                                                        <td>{{$er->objetivo}}</td>
                                                        @if($er->idMunicipio!=NULL || $er->idMunicipio!='')
                                                        <td>{{$er->municipality->name}}</td>
                                                        @else
                                                        <td>NA</td>
                                                        @endif
                                                        <td> 
                                                            <div class="btn-group">
                                                                <button type="button" 
                                                                        class="btn btn-info" 
                                                                        data-toggle="modal" 
                                                                        data-id="{{$er->id}}"
                                                                        data-title="Evento: {{$er->nombre}}"
                                                                        data-target="#infoEvent">Ver &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye" aria-hidden="true"></i></button>
                                                                <br>&nbsp;
                                                                <a href="{{URL::to('generarpdf/'.$er->id)}}" target="_blank"><button  type="submit" class="btn btn-success" title="Descargar PDF">PDF &nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
                                                                <br>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                @endif
                                @if(isset($messageEquipo))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-success">
                                            <strong>{{$messageEquipo}}</strong>
                                        </div> 
                                    </div>
                                </div>
                                <br>
                                @endif 
                                @if(isset($noequipo))
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="alert alert-danger">
                                            <strong>{{$noequipo}}</strong>
                                        </div> 
                                    </div>
                                </div>
                                <br>
                                @endif           
                                @if(isset($eventos_equipo))

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                <th>ID</th>
                                                <th>Nombre</th>
                                                <th>Fecha del evento</th>
                                                <th>Objetivo</th>
                                                <th>Municipio</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody>
                                                    @foreach($eventos_equipo  as $ee)
                                                    <tr>
                                                        <td>{{$ee->id}}</td>
                                                        <td>{{$ee->nombre}}</td>
                                                        <td>{{$ee->f_inicio}}</td>
                                                        <td>{{$ee->objetivo}}</td>
                                                        @if($ee->idMunicipio != NULL || $ee->idMunicipio != '')
                                                        <td>{{$ee->municipality->name}}</td>
                                                        @else
                                                        <td>NA</td>
                                                        @endif
                                                        <td> 
                                                            <div class="btn-group">
                                                                <button type="button" 
                                                                        class="btn btn-info" 
                                                                        data-toggle="modal" 
                                                                        data-id="{{$ee->id}}"
                                                                        data-title="Evento: {{$ee->nombre}}"
                                                                        data-target="#infoEvent">Ver &nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-eye" aria-hidden="true"></i></button>

                                                                <button class="btn btn-success" title="Descargar PDF" data-toggle="tooltip">PDF &nbsp;&nbsp;&nbsp;<i class="fa fa-file-pdf-o" aria-hidden="true"></i></button>
                                                                <br>&nbsp;
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    @endforeach

                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                </div>
                                @endif
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </div>
        <div class="modal fade" id="infoEvent" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document" id="mdialTamanio">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" 
                                data-dismiss="modal" 
                                aria-label="Close">
                            <span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" 
                            id="infoEventLabel">Informaci&oacute;n del evento</h4>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="alerta_informacion" style="display:none">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" >
                                    Aun no se registra la informaci&oacute;n del evento
                                </div>
                            </div>
                        </div>
                        <div class="row" id="alerta_place" style="display:none">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" >
                                    Aun no se registran los datos de caracter&iacute;sticas del lugar
                                </div>
                            </div>
                        </div>
                        <div class="row" id="alerta_program" style="display:none">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" >
                                    Aun no se registran los datos del programa e invitados
                                </div>
                            </div>
                        </div>
                        <div class="row" id="alerta_logistic" style="display:none">
                            <div class="col-sm-12">
                                <div class="alert alert-danger" >
                                    Aun no se registran los datos de los requerimientos
                                </div>
                            </div>
                        </div>
                        <div class="form-group" id="info_general" style="display:block;">
                            <center><h2>Informaci&oacute;n general del evento</h2></center>
                            <hr>                       
                            {!! Form::open(['route' => 'evento.editarEventoBase','id'=>'editarBaseEvent','files'=>true])!!}
                            {{ csrf_field() }}
                            <input type="hidden" id="idEvent" name="idEvent" class="form-control">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('nombre','Nombre del evento: ')!!}
                                        {!! Form::text('nombre',null,['class' => 'form-control','required' => 'required','onkeyup'=>'aMays(event,this)'])!!}
                                    </div>

                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="fi">Fecha del evento:</label>
                                        <input id="fi" class="date-picker form-control calendario" required="required" type="text" name="fi" readonly="true">                                            </div>
                                </div> 

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora de inicio del evento:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                            <input type="text" id="hi" name="hi" class="form-control" value="09:30" readonly="true">
                                            <span class="input-group-addon" id="hi" name="hi">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora de conclusi&oacute;n del evento:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true" >                                                 
                                            <input type="text" id="hf" name="hf" class="form-control" value="10:30" readonly="true"> 
                                            <span class="input-group-addon" id="hf" name="hf">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora estimada de arribo del candidato:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                            <input type="text" id="h_arribo" name="h_arribo" class="form-control" value="10:30" readonly="true">
                                            <span class="input-group-addon" id="h_arribo" name="h_arribo">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>   
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora de convocatoria:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                            <input type="text" id="h_convocatoria" name="h_convocatoria" class="form-control" value="09:30" readonly="true">
                                            <span class="input-group-addon" id="h_convocatoria" name="h_convocatoria">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>                           
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('calle_numero','Calle y numero: ')!!}
                                        {!! Form::text('calle_numero',null,['class' => 'form-control','required' => 'required','onkeyup'=>'aMays(event,this)'])!!}
                                    </div>
                                </div> 

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('cp','Ingresa el C.P: ')!!}
                                        {!! Form::text('cp',null,['class' => 'form-control','required' => 'required','onkeypress'=>'return justNumbers(event)','maxlength'=>'5','minlength'=>'5'])!!}
                                    </div>
                                </div> 
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('colonia','Ingresa la colonia: ')!!}
                                        {!! Form::text('colonia',null,['class' => 'form-control','required' => 'required','onkeyup'=>'aMays(event,this)'])!!}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="municipio">Escoge el municipio:</label>
                                        <select id="municipio" class="form-control" name="municipio" required>
                                            @if(isset($municipios))
                                            @foreach($municipios as $municipio)
                                            <option value="{{$municipio->id}}">{{$municipio->name}}</option>
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> 

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="seccion_impactada">Secci&oacute;nal:</label>
                                        <select id="seccion_impactada" name="seccion_impactada" class="form-control" required="true">

                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="distrito">Distrito:</label>
                                        <select id="distrito" name="distrito" class="form-control" required="true">
                                            <option value="I">I</option>
                                            <option value="II">II</option>
                                            <option value="III">III</option>
                                            <option value="IV">IV</option>
                                            <option value="V">V</option>
                                            <option value="VI">VI</option>
                                            <option value="VII">VII</option>
                                            <option value="VIII">VIII</option>
                                            <option value="IX">IX</option>
                                            <option value="X">X</option>
                                            <option value="XI">XI</option>
                                            <option value="XII">XII</option>
                                            <option value="XIII">XIII</option>
                                            <option value="XIV">XIV</option>
                                            <option value="XV">XV</option>
                                            <option value="XVI">XVI</option>
                                            <option value="XVII">XVII</option>
                                            <option value="XVIII">XVIII</option>
                                            <option value="XIX">XIX</option>
                                            <option value="XX">XX</option>
                                            <option value="XXI">XXI</option>
                                            <option value="XXII">XXII</option>
                                            <option value="XXIII">XXIII</option>
                                            <option value="XXIV">XXIV</option>
                                            <option value="XXV">XXV</option>
                                            <option value="XXVI">XXVI</option>
                                            <option value="XXVII">XXVII</option>
                                            <option value="XXVIII">XXVIII</option>
                                            <option value="XXIX">XXIX</option>
                                            <option value="XXX">XXX</option>
                                            <option value="XXXI">XXXI</option>
                                            <option value="XXXII">XXXII</option>
                                            <option value="XXXIII">XXXIII</option>
                                            <option value="XXXIV">XXXIV</option>
                                            <option value="XXXV">XXXV</option>
                                            <option value="XXXVI">XXXVI</option>
                                            <option value="XXXVII">XXXVII</option>
                                            <option value="XXXVIII">XXXVIII</option>
                                            <option value="XXXIX">XXXIX</option>
                                            <option value="XL">XL</option>
                                            <option value="XLI">XLI</option>
                                            <option value="XLII">XLII</option>
                                            <option value="XLIII">XLIII</option>
                                            <option value="XLIV">XLIV</option>
                                            <option value="XLV">XLV</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            Informaci&oacute;n del responsable
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('responsable_politico','Responsable pol&iacute;tico: ')!!}
                                        {!! Form::text('responsable_politico',null,['class' => 'form-control','id'=>'responsable_politico','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('cargo_responsable_politico','Cargo: ')!!}
                                        {!! Form::text('cargo_responsable_politico',null,['class' => 'form-control','id'=>'cargo_responsable_politico','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::label('foto_responsable_politico', 'Foto: &nbsp;') !!}
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="foto_responsable_politico" id="foto_responsable_politico" >
                                        <div class='text-danger'>{{$errors->first('image')}}</div>                                        </span>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div id="foto_responsable_politico_div"></div>
                                </div>
                                <div class="col-sm-3"></div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('telefono_responsable_politico','Tel&eacute;fono:')!!}
                                        {!! Form::text('telefono_responsable_politico',null,['class' => 'form-control','id'=>'telefono_responsable_politico','onkeypress'=>'return justNumbers(event)','maxlength'=>'10','minlength'=>'10'])!!}                              
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('email_responsable_politico','Email:')!!}
                                        {{ Form::email('email_responsable_politico', null,['class' => 'form-control', 'placeholder'=>'Ingrese email']) }}
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('responsable_operativo','Responsable operativo: ')!!}
                                        {!! Form::text('responsable_operativo',null,['class' => 'form-control','id'=>'responsable_operativo','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('cargo_responsable_operativo','Cargo: ')!!}
                                        {!! Form::text('cargo_responsable_operativo',null,['class' => 'form-control','id'=>'cargo_responsable_operativo','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('telefono_responsable_operativo','Tel&eacute;fono:')!!}
                                        {!! Form::text('telefono_responsable_operativo',null,['class' => 'form-control','id'=>'telefono_responsable_operativo','onkeypress'=>'return justNumbers(event)','maxlength'=>'10','minlength'=>'10'])!!}                         
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('email_responsable_operativo','Email:')!!}
                                        {{ Form::email('email_responsable_operativo', null,['class' => 'form-control', 'placeholder'=>'Ingrese email']) }}
                                    </div>
                                </div>
                            </div>
                            <hr>

                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::label('foto_responsable_operativo', 'Recorrido/Distribuci&oacute;n log&iacute;stica (FICHA): &nbsp;') !!}
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="foto_responsable_operativo" id="foto_responsable_operativo" >
                                        <div class='text-danger'>{{$errors->first('image')}}</div>                                        </span>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div id="foto_responsable_operativo_div"></div>
                                </div>
                                <div class="col-sm-3"></div>

                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="objetivo">Objetivo del evento:</label>
                                        <textarea id="objetivo" class="form-control" name="objetivo" required rows="6" onkeypress="aMays(event, this);">
                                        </textarea>
                                    </div>
                                </div> 

                            </div>
                            @if(Auth::user()->level==1)
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="responsable">Escoge el responsable de la pre-gira:</label>
                                        <select id="responsable" class="form-control" name="responsable" >
                                            @if(isset($profiles))
                                            @foreach($profiles as $profile)
                                            @if(isset($profile->profile))
                                            <option value="{{$profile->profile->id}}">{{$profile->profile->name}}&nbsp;{{$profile->profile->ap_paterno}}&nbsp;{{$profile->profile->ap_materno}}</option>
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> 

                            </div>
                            @endif
                            @if(Auth::user()->level==2)
                            <div class="row" style="display:none">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="responsable">Escoge el responsable de la pre-gira:</label>
                                        <select id="responsable" class="form-control" name="responsable">
                                            @if(isset($profiles))
                                            @foreach($profiles as $profile)
                                            @if(isset($profile->profile))
                                            <option value="{{$profile->profile->id}}">{{$profile->profile->name}}&nbsp;{{$profile->profile->ap_paterno}}&nbsp;{{$profile->profile->ap_materno}}</option>
                                            @endif
                                            @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div> 

                            </div>
                            @endif
                            <div class="row">
                                <div class="col-sm-12">
                                    <p><b>Da click en el mapa para seleccionar la localizacion del evento</b></p>

                                </div>
                            </div>    
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" id="lat" name="lat" class="form-control" readonly="true">
                                    </div>

                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="text" id="lng" name="lng" class="form-control" readonly="true">
                                    </div>

                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-6"></div>
                                <div class="col-sm-6">
                                    <div class="btn-group" style="float:right;">
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">Cerrar</button>
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="firstSteep">Siguiente</button>
                                        {!! Form::submit('Guardar',['class' => 'btn btn-success','name'=>'bttEnviarInfoGeneral'])!!}
                                        {!!Form::close()!!}
                                    </div>
                                </div>



                            </div>


                            <button id="btt-seach" name="btt-search" class="btn btn-primary" onclick="codeAddress()">Buscar direcci&oacute;n escrita arriba</button>
                        </div>
                        <div id="info_territorial" style="display:none">
                            <center><h2>Informaci&oacute;n del evento</h2></center>
                            <hr>
                            {!! Form::open(['route' => 'informations.store', 'method' => 'POST','files'=>true,'id'=>'formInformation'])!!}
                            <input type="hidden" id="idEvento" name="idEvento">
                            <input type="hidden" id="idInformation" name="idInformation" disabled="true">
                            <!--div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('responsable_informacion','Responsable dformInformationel evento: ')!!}
                                        {!! Form::text('responsable_informacion',null,['class' => 'form-control','required' => 'required','id'=>'responsable_informacion'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('cargo_responsable','Cargo del responsable evento: ')!!}
                                        {!! Form::text('cargo_responsable',null,['class' => 'form-control','required' => 'required','id'=>'cargo_responsable'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    {!! Form::label('foto', 'Foto del responsable: &nbsp;') !!}
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <input type="file" class="form-control" name="foto_responsable" id="foto_responsable" >
                                        <div class='text-danger'>{{$errors->first('image')}}</div>                                        </span>
                                    </div>                                    
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-6">
                                    <div id="foto_responsable_evento"></div>
                                </div>
                                <div class="col-sm-3"></div>
    
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('telefono_responsable','Tel&eacute;fono del responsable:')!!}
                                        {!! Form::text('telefono_responsable',null,['class' => 'form-control','required' => 'required','id'=>'telefono_responsable'])!!}                              
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        {!! Form::label('email_responsable','Email del responsable:')!!}
                                        {{ Form::email('email_responsable', 'noreply@gmail.com', ['class' => 'form-control']) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora estimada de arribo del candidato:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                            <input type="text" id="h_arribo" name="h_arribo" class="form-control" value="09:30">
                                            <span class="input-group-addon" id="h_arribo" name="h_arribo">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>   
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label for="hi">Hora de convocatoria:</label>
                                        <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                            <input type="text" id="h_convocatoria" name="h_convocatoria" class="form-control" value="09:30">
                                            <span class="input-group-addon" id="h_convocatoria" name="h_convocatoria">
                                                <span class="fa fa-clock-o"></span>
                                            </span>
                                        </div>                                            </div>
                                </div>                           
                            </div-->
                            <!--div class="row">
                                <div class="col-sm-12">
                                    <fieldset>
                                        <div class="form-group">
    
                                            <label for="horario1">Comit&eacute; de recepci&oacute;n:</label><br>
                                            <div class="row">
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Nombre</b></label><br>
                                                </div>
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Cargo</b></label><br>
                                                </div>
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Observaciones</b></label><br>
                                                </div>
                                            </div>
    
    
                                            <div id="inputComitebienvenida1" style="margin-bottom:4px;" class="clonedInput98 form-group" class="form-group" class="form-control">  
                                                <div class="row">
                                                    <div class="col-sm-4">        
                                                        <input type="text" class="form-control" id="ComitebienvenidaNombre1" name="ComitebienvenidaNombre[]">
                                                    </div>
                                                    <div class="col-sm-4">        
                                                        <input type="text" class="form-control" id="ComitebienvenidaCargo1" name="ComitebienvenidaCargo[]">
                                                    </div>
                                                    <div class="col-sm-4">   
                                                        <input type="text"  class="form-control" id="ComitebienvenidaObservaciones1" name="ComitebienvenidaObservaciones[]" value="" >
                                                    </div>
                                                </div>
                                            </div>
                                            <br>
                                            <div>
                                                <input type="button" class="btn btn-success" id="btnAddComitebienvenida" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelComitebienvenida" value="-" />
                                            </div>
                                        </div>
    
                                    </fieldset>
    
                                </div>
                            </div>
    
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="comite_de_bienvenida">
                                            <thead>
                                            <th>Nombre</th>
                                            <th>Cargo</th>  
                                            <th>Observaciones</th>
                                            <th>Men&uacute;</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div-->
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group"><label>Tipo de evento:</label></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="encuentro">Formal</label>

                                        {{ Form::radio('tipo_evento', 'ENCUENTRO', true, ['class' => 'radio','id' => 'encuentro' ]) }}

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="dialogo">Di&aacute;logo</label>
                                        {{ Form::radio('tipo_evento', 'DIALOGO', false, ['class' => 'radio','id' => 'dialogo' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="vista">Visita o Recorrido</label>
                                        {{ Form::radio('tipo_evento','VISTA', false, ['class' => 'radio','id' => 'vista' ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="debate">Debate</label>
                                        {{ Form::radio('tipo_evento','DEBATE', false, ['class' => 'radio','id' => 'debate' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="foro">Foro</label>
                                        {{ Form::radio('tipo_evento','FORO', false, ['class' => 'radio','id' => 'foro' ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group"><label>Tipo de vestimenta:</label></div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="formal">Formal</label>

                                        {{ Form::radio('vestimenta', 'FORMAL', true, ['class' => 'radio','id' => 'formal' ]) }}&nbsp;&nbsp;

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="informal">Informal</label>
                                        {{ Form::radio('vestimenta', 'INFORMAL', false, ['class' => 'radio','id' => 'informal' ]) }}&nbsp;&nbsp;
                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="casual">Casual</label>
                                        {{ Form::radio('vestimenta','CASUAL', false, ['class' => 'radio','id' => 'casual' ]) }}
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="sugerenciavestimenta">Sugerencia de vestimenta:</label>
                                        <textarea id="sugerenciavestimenta" name="sugerenciavestimenta" class="form-control" rows="4" placeholder="Ingrese una breve sugerencia" onkeyup="aMays(event, this);" ></textarea>
                                    </div>
                                </div>
                            </div> 
                            <div class="row">
                                <div class="col-sm-3">
                                    <p><b>Rentabilidad:</b></p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="politica">Pol&iacute;tica</label>

                                        {{ Form::radio('rentabilidad', 'POLITICA', true, ['class' => 'radio','id' => 'politica' ]) }}&nbsp;&nbsp;

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="estrategica">Estrat&eacute;gica</label>
                                        {{ Form::radio('rentabilidad', 'ESTRATEGICA', false, ['class' => 'radio','id' => 'estrategica' ]) }}&nbsp;&nbsp;
                                    </div>
                                </div>

                            </div>
                            <!--div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="trascendencia">Trascendencia:</label>
                                        <select id="trascendencia" name="trascendencia" class="form-control" required="true">
                                            <option value="SECCIONAL">Seccional</option>
                                            <option value="MUNICIPAL">Municipal</option>
                                            <option value="DISTRITAL">Distrital</option>
                                            <option value="REGIONAL">Regional</option>
                                            <option value="ESTATAL">Estatal</option>
                                        </select>
                                    </div>
                                </div>
                            </div-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('asistentes_aprox','Asistentes aproximados: ')!!}
                                        {!! Form::text('asistentes_aprox',null,['class' => 'form-control','id'=>'asistentes_aprox','onkeypress'=>'return justNumbers(event)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="participacioncandidato">Participaci&oacute;n del candidato:</label>
                                        <select id="participacioncandidato" name="participacioncandidato" class="form-control" required="true">
                                            <option value="MASIVA">Masiva</option>
                                            <option value="REUNION_PRIVADA">Reuni&oacute;n privada</option>
                                            <option value="CONFERENCIA_DE_PRENSA">Conferencia de prensa</option>
                                            <option value="ENCUENTRO_CON_MILITANTES">Encuentro con militantes</option>
                                            <option value="ENCUENTRO_SECTORIAL">Encuentro sectorial</option>
                                            <option value="ENCUENTRO_CON_SOCIEDAD_CIVIL">Encuentro con sociedad civil</option>
                                            <option value="0">Otra</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="otro_div_participacion" style="display:none;">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('otro_participacion','Otra participaci&oacute;n: ')!!}
                                        {!! Form::text('otro_participacion',null,['class' => 'form-control','id'=>'otro_participacion','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <!--div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group"><label>Alimentos:</label></div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="desayuno">Desayuno</label>
    
                                        {{ Form::radio('alimentos', 'DESAYUNO', true, ['class' => 'radio','id' => 'desayuno' ]) }}
    
                                    </div>
                                </div>
    
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="comida">Comida</label>
                                        {{ Form::radio('alimentos', 'COMIDA', false, ['class' => 'radio','id' => 'comida' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cena">Cena</label>
                                        {{ Form::radio('alimentos','CENA', false, ['class' => 'radio','id' => 'cena' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
    
                                        <input type="radio" name="alimentos"  value="0">Otro <input type="text" class="form-control" name="other_alimentos" id="other_alimentos"/>
                                    </div>
                                </div>
                            </div-->

                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="sector">Sector:</label>
                                        <select id="sector" name="sector" class="form-control" required="true">
                                            <option value="MILITANCIA">Militancia</option>
                                            <option value="JUVENTUD">Juventud</option>
                                            <option value="MUJERES">Mujeres</option>
                                            <option value="ADULTOS MAYORES">Adultos mayores</option>
                                            <option value="CAPACIDADES DIFERENTES">Capacidades diferentes</option>
                                            <option value="LGBTTTI">LGBTTTI</option>
                                            <option value="DEPORTISTAS">Deportistas</option>
                                            <option value="ARTISTAS E INTELECTUALES">Artistas e Intelectuales</option>
                                            <option value="RELIGION">Religi&oacute;n</option>
                                            <option value="INDIGENA">Indigena</option>
                                            <option value="OBRERO">Obrero</option>
                                            <option value="CAMPESINO">Campesino</option>
                                            <option value="A. CIVILES">A. Civiles</option>
                                            <option value="SINDICATOS">Sindicatos</option>
                                            <option value="ARTESANOS">Artesanos</option>
                                            <option value="COMERCIANTES">Comerciantes</option>
                                            <option value="ESTUDIANTES">Estudiantes</option>
                                            <option value="EMPRESARIOS">Empresarios</option>
                                            <option value="TRANSPORTISTAS">Transportistas</option>
                                            <option value="0">Otro</option>
                                        </select>
                                    </div>
                                </div>
                            </div>  

                            <div class="row" id="otro_div_sector" style="display:none;">
                                <div class="col-sm-12">
                                    <div class='form-group'>
                                        {!! Form::label('otro_sector','Otro sector: ')!!}
                                        {!! Form::text('otro_sector',null,['class' => 'form-control','id'=>'otro_sector','onkeyup'=>'aMays(event,this)'])!!}                              
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        {!! Form::label('tema','Tema: ')!!}
                                        {!! Form::text('tema',null,['class' => 'form-control','id'=>'tema','onkeyup'=>'aMays(event,this)'])!!} 
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><b>Folletos:</b></p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="si">Si</label>

                                        {{ Form::radio('folletos', 'SI', true, ['class' => 'radio','id' => 'si' ]) }}&nbsp;&nbsp;

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="no">No</label>
                                        {{ Form::radio('folletos', 'NO', false, ['class' => 'radio','id' => 'no' ]) }}&nbsp;&nbsp;
                                    </div>
                                </div>

                            </div>
                            <div class="row">
                                <div class="col-sm-6">
                                    <p><b>Utilitarios:</b></p>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="si">Si</label>

                                        {{ Form::radio('utilitarios', 'SI', true, ['class' => 'radio','id' => 'si' ]) }}&nbsp;&nbsp;

                                    </div>
                                </div>
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label for="no">No</label>
                                        {{ Form::radio('utilitarios', 'NO', false, ['class' => 'radio','id' => 'no' ]) }}&nbsp;&nbsp;
                                    </div>
                                </div>

                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-7">

                                    <div class="btn-group" style="float:right;">
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">Cerrar</button> 
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="secondSteep">Anterior</button>
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="thirdSteep">Siguiente</button>

                                        {!! Form::submit('Guardar',['class' => 'btn btn-success','name'=>'bttEnviarInfo'])!!}
                                    </div>
                                </div>  


                            </div> 
                            {!! Form::close()!!}
                        </div>
                        <div id="info_places" style="display:none">
                            <center><h2>Caractet&iacute;sticas del lugar</h2></center>

                            {!! Form::open(['route' => 'places.store', 'method' => 'POST','files'=>true,'id'=>'placesForm'])!!}
                            <input type="hidden" id="idEventoPlaces" name="idEventoPlaces">
                            <hr>

                            <div class="row">
                                <div class="col-sm-2">
                                    <p><b>Lugar:</b></p>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="cerrado"><br>Cerrado <br></label>

                                        {{ Form::radio('lugar', 'CERRADO', true, ['class' => 'radio','id' => 'cerrado' ]) }}

                                    </div>
                                </div>

                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="abierto"><br>Abierto <br></label>
                                        {{ Form::radio('lugar', 'ABIERTO', false, ['class' => 'radio','id' => 'abierto' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="publico">Espacio P&uacute;blico</label>
                                        {{ Form::radio('lugar','ESPACIO_PUBLICO', false, ['class' => 'radio','id' => 'publico' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="privado">Espacio Privado</label>
                                        {{ Form::radio('lugar','ESPACIO_PRIVADO', false, ['class' => 'radio','id' => 'privado' ]) }}
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <br>
                                    <div class="form-group">
                                        <input type="radio" name="lugar"  value="0">Otro <input type="text" class="form-control" name="other_lugar" id="other_lugar"/>
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="nota_publico" style="display:none">
                                <div class="col-sm-12">
                                    <div class="alert alert-danger"><p>Recuerda que los espacios p&uacute;blicos se deben pedir con anticipaci&oacute;n</p></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="descripcion_lugar">Descripci&oacute;n f&iacute;sica del lugar:</label>
                                        <textarea id="descripcion_lugar" class="form-control" name="descripcion_lugar" rows="4" placeholder="Ingrese una breve descripción" onkeyup='aMays(event, this);'></textarea>
                                    </div>
                                </div> 

                            </div>
                            <div class="row">
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label>Accesos del lugar:</label>
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="terraceria">Terraceria</label>
                                        <input type="radio" class="radio" name="acceso_lugar" id="terraceria" value="TERRACERIA" checked="true">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="empedrado">Empedrado</label>
                                        <input type="radio" class="radio" name="acceso_lugar" id="empedrado" value="EMPEDRADO">
                                    </div>
                                </div>
                                <div class="col-sm-2">
                                    <div class="form-group">
                                        <label for="pavimentado">Pavimentado</label>
                                        <input type="radio"  class="radio" name="acceso_lugar" id="pavimentado" value="PAVIMENTADO">
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label for="otro">Otro</label>
                                        <input type="radio" class="radio" name="acceso_lugar" id="otro" value="0"><input type="text" name="other_acceso" id="other_acceso" onkeyup="aMays(event, this);"/>                                </div>
                                </div>




                            </div>
                            <hr>
                            <center><h3>Im&aacute;genes del lugar</h3></center>
                            <hr>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="imagenes_lugar_frente">Subir imagen de frente:</label>
                                        {!! Form::file('fotoslugar_frente', array('class'=>'form-control','id'=>'imagenes_lugar_frente')) !!}
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="fotos_del_lugar_frente"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="imagenes_lugar_atras">Subir imagen de atras:</label>
                                        {!! Form::file('fotoslugar_atras', array('class'=>'form-control','id'=>'imagenes_lugar_atras')) !!}
                                    </div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="fotos_del_lugar_atras"></div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="imagenes_lugar_exterior">Subir imagen del exterior:</label>
                                        {!! Form::file('fotoslugar_exterior', array('class'=>'form-control','id'=>'imagenes_lugar_exterior')) !!}
                                    </div>

                                </div>
                            </div>


                            <div class="row">
                                <div class="col-sm-12">
                                    <div id="fotos_del_lugar_exterior"></div>
                                </div>
                            </div>
                            <hr>

                            <!--div class="row">
                                <div class="col-sm-12">
                                    <fieldset>
                                        <div class="form-group">

                                            <label for="horario1"><i>Actores pol&iacute;ticos:</i></label><br>
                                            <div class="row">
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Nombre</b></label><br>
                                                </div>
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Cargo</b></label><br>
                                                </div>
                                                <div class="col-sm-4 ">
                                                    <label for="nombrecampos"><b>Observaciones</b></label><br>
                                                </div>
                                            </div>


                                            <div id="inputAutoridadeslugar1" style="margin-bottom:4px;" class="clonedInput form-group" class="form-group" class="form-control">  
                                                <div class="row">
                                                    <div class="col-sm-4">        
                                                        <input type="text" class="form-control" id="AutoridadeslugarNombre1" name="AutoridadeslugarNombre[]">
                                                    </div>
                                                    <div class="col-sm-4">   
                                                        <select class="form-control" id="AutoridadeslugarCargo1" name="AutoridadeslugarCargo[]">
                                                            <option value="PM">PM</option>
                                                            <option value="PRESIDENTE DE COMIE">PM</option>
                                                            <option value="DIP. FEDERAL">DF</option>
                                                            <option value="DELEGADO MUNICIPAL">DL</option>
                                                            <option value="COORDINADOR MUNICIPAL">P. Comit&eacute; Municipal</option>
                                                            <option value="DELEGADO MUNICIPAL">Del. Municipal</option>
                                                            <option value="COORDINADOR REGIONAL">Coord. Regional</option>
                                                            <option value="OTRO">Otro</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-4">   
                                                        <input type="text"  class="form-control" id="AutoridadeslugarObservaciones1" name="AutoridadeslugarObservaciones[]" value="" >
                                                    </div>
                                                </div>
                                            </div>

                                            <div>
                                                <input type="button" class="btn btn-success" id="btnAddAutoridadeslugar" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelAutoridadeslugar" value="-" />
                                            </div>
                                        </div>

                                    </fieldset>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="table-responsive">
                                        <table class="table table-hover" id="autoridades_del_lugar">
                                            <thead>
                                            <th>Nombre</th>
                                            <th>Cargo</th>  
                                            <th>Observaciones</th>
                                            <th>Men&uacute;</th>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div-->
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="riesgos_sociales">Riesgos que puedan alterar el buen desarrollo  del evento:</label>
                                        <textarea id="riesgos_sociales" name="riesgos_sociales" class="form-control" rows="5" onkeyup="aMays(event, this);"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label for="problematica_politica">Posible problem&aacute;tica pol&iacute;tica:</label>
                                        <textarea id="problematica_politica" name="problematica_politica" class="form-control" rows="5" onkeyup="aMays(event, this);"></textarea>
                                    </div>
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-7">
                                    <div class="btn-group" style="float:right;">
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">Cerrar</button> 
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="returnSecondSteep">Anterior</button>
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="nextFromPlaces">Siguiente</button>              
                                        {!! Form::submit('Guardar',['class' => 'btn btn-success','name'=>'bttEnviarPlace'])!!}
                                    </div>
                                </div>  

                                {!! Form::close() !!}
                            </div> 
                        </div>
                        <div id="info_programs" style="display:none">
                            <center><h2>Programa e invitados especiales</h2></center>
                            {!! Form::open(['route' => 'programs.store', 'method' => 'POST','files'=>true,'id'=>'programForm'])!!}
                            <input type="hidden" id="idEventPrograms" name="idEventPrograms">
                            <hr>
                            <fieldset>

                                <!-- INICIA PRESIDIUM FORMULARIO DINAMICO -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Presidium:</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>&nbsp&nbsp Orden</b></label><br>

                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>&nbsp&nbsp Nombre</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>&nbsp&nbsp Cargo</b></label><br>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="inputPresidium1" style="margin-bottom:4px;" class="clonedInput99" class="form-group" class="form-control">
                                        <div class="col-md-2 "></div>  
                                        <div class="row">
                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="number" id="PresidiumNumero1" name="PresidiumNumero[]" min="1" max="30" value="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">
                                                    <input type="text" id="PresidiumNombre1" name="PresidiumNombre[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">

                                                    <input type="text" id="PresidiumCargo1" name="PresidiumCargo[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>

                                        </div>
                                        <div class="row"> 
                                            <div class="col-sm-2"><label>Foto: &nbsp;&nbsp;&nbsp;</label></div>
                                            &nbsp;&nbsp;&nbsp; <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="file" id="PresidiumFoto1" class="form-control" name="PresidiumFoto[]">
                                                    <div class='text-danger'>{{$errors->first('image')}}</div>                                        </span>
                                                </div>                                    
                                            </div></div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                &nbsp&nbsp      
                                                <input type="button" class="btn btn-success" id="btnAddPresidium" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelPresidium" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA PRESIDIUM FORMULARIO DINAMICO -->
                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_presidium">
                                                <thead>
                                                <th>Orden</th>
                                                <th>Nombre</th>  
                                                <th>Cargo</th>
                                                <th>Foto</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- INICIA INVITADOS E  FORMULARIO DINAMICO -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Invitados Especiales:</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Orden</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Nombre</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Cargo</b></label><br>
                                        </div>
                                    </div>


                                    <div id="inputInvitadosE1" style="margin-bottom:4px;" class="clonedInput2" class="form-group" class="form-control">
                                        <div class="col-md-2 "></div>  
                                        <div class="row">
                                            <div class="col-md-3 ">        
                                                <input type="number" id="InvitadosENumero1" name="InvitadosENumero[]" min="1" max="30" value="1" class="form-control">
                                            </div>
                                            <div class="col-md-3 ">   
                                                <input type="text" id="InvitadosENombre1" name="InvitadosENombre[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">  
                                                    <input type="text" id="InvitadosECargo1" name="InvitadosECargo[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row"> 

                                            <div class="col-sm-2"><label>Foto: &nbsp;&nbsp;&nbsp;</label></div>
                                            &nbsp;&nbsp;&nbsp; <div class="col-sm-9">
                                                <div class="form-group">
                                                    <input type="file" class="form-control" name="InvitadosEFoto[]" id="InvitadosEFoto1" >
                                                    <div class='text-danger'>{{$errors->first('image')}}</div>                                        </span>
                                                </div>                                    
                                            </div></div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                &nbsp&nbsp      
                                                <input type="button" class="btn btn-success" id="btnAddInvitadosE" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelInvitadosE" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA INVITADOS E FORMULARIO DINAMICO -->

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_invitados">
                                                <thead>
                                                <th>Orden</th>
                                                <th>Nombre</th>  
                                                <th>Cargo</th>
                                                <th>Foto</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!-- INICIA INVITADOS E  FORMULARIO DINAMICO -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Personas suceptibles de mencionar en mensaje:</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Orden</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Nombre</b></label><br>
                                        </div>
                                        <div class="col-md-3 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Justificacion de la mension</b></label><br>
                                        </div>

                                    </div>


                                    <div id="inputPrimeraslineas1" style="margin-bottom:4px;" class="clonedInput97" class="form-group" class="form-control">
                                        <div class="col-md-2 "></div>  
                                        <div class="row">
                                            <div class="col-md-3 ">   
                                                <input type="number" id="PrimeraslineasNumero1" name="PrimeraslineasNumero[]" value="1" min="1" max="30" class="form-control">
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">  
                                                    <input type="text" id="PrimeraslineasNombre1" name="PrimeraslineasNombre[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">  
                                                    <input type="text" id="PrimeraslineasJustificacion1" name="PrimeraslineasJustificacion[]" onkeyup="aMays(event, this);" value="" class="form-control">
                                                </div>
                                            </div>

                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                &nbsp&nbsp      
                                                <input type="button" class="btn btn-success" id="btnAddPrimeraslineas" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelPrimeraslineas" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA INVITADOS E FORMULARIO DINAMICO -->

                                <hr>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_lineas">
                                                <thead>
                                                <th>Orden</th>
                                                <th>Nombre</th>  
                                                <th>Justificaci&oacute;n de la menci&oacute;n</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <!--INICIA TEXT AREA-->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="summernote"><b>Líneas discursivas (Información para el C. Candidato, incluyendo principales demandas):</b></label><br>
                                        </div>
                                        <div class="col-md-8 ">   
                                            <textarea id="summernote" name="contenido" rows="0" style="display:none;" onkeyup="aMays(event, this);"></textarea>
                                            ESCRIBE AQUÍ INFORMACIÓN RELEVANTE PARA EL CANDIDATO
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA TEXT AREA-->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="summernote2"><b>Asistentes (Ficha): </b></label><br>
                                        </div>
                                        <div class="col-md-8 ">   
                                            <textarea id="summernote2" name="asistentes_ficha" rows="0" style="display:none;" onkeyup="aMays(event, this);"></textarea>
                                        </div>
                                    </div>
                                </div>

                                <!-- Inicia mensaje de o si lo prefieres-->
                                <div class="row">
                                    <div class="col-md-10 ">
                                        <label for="nombrecampos">si prefieres puedes adjuntar información</label><br><br>
                                    </div>
                                </div>
                                <!--Termina mensaje de  o si lo prefieres-->


                                <!--INICIA INPUT FILE Líneas Discursivas -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Líneas Discursivas Adjunto</b></label><br>
                                        </div>
                                        <div class="col-md-8 ">   
                                            <input type="file" id="archivo_lineas_discursivas" name="archivo_lineas_discursivas" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA INPUT FILE Líneas Discursivas -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="discursivas_download"></div>
                                    </div>
                                </div>

                                <!-- INICIA Orden del Día   FORMULARIO DINAMICO -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Orden del Día:</b></label><br>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp N.P</b></label><br>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b> Intervenci&oacute;n</b></label><br>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Cargo</b></label><br>
                                        </div>
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>&nbsp&nbsp Duración (minutos)</b></label><br>
                                        </div>
                                    </div>


                                    <div id="inputOrdenDia1" style="margin-bottom:4px;" class="clonedInput3" class="form-group" class="form-control">
                                        <div class="col-md-2 "></div>  
                                        <div class="row">
                                            <div class="col-md-2 ">        
                                                <input type="number" id="OrdenDiaNumero1" name="OrdenDiaNumero[]" value="1" min="1" max="30"  class="form-control">
                                            </div>
                                            <div class="col-md-2 ">   
                                                <input type="text" id="OrdenDiaIntervencion1" name="OrdenDiaIntervencion[]" onkeyup="aMays(event, this);" value=""  class="form-control">
                                            </div>
                                            <div class="col-md-2 ">   
                                                <input type="text" id="OrdenDiaCargo1" name="OrdenDiaCargo[]" value="" onkeyup="aMays(event, this);" class="form-control">
                                            </div>
                                            <div class="col-md-2 ">   
                                                <input type="text" id="OrdenDiaDuracion1" name="OrdenDiaDuracion[]" value="" onkeypress="return justNumbers(event)" class="form-control">
                                            </div>
                                        </div>
                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                &nbsp&nbsp      
                                                <input type="button" class="btn btn-success" id="btnAddOrdenDia" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelOrdenDia" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA Orden del Día  E FORMULARIO DINAMICO -->
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_ordendia">
                                                <thead>
                                                <th>N.P</th>
                                                <th>Intervenci&oacute;n</th>  
                                                <th>Cargo</th>
                                                <th>Duraci&oacute;n</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <br>

                                <!--INICIA INPUT FILE Líneas Discursivas -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Programa del Evento:</b></label><br>
                                        </div>
                                        <div class="col-md-8 ">   
                                            <input type="file" id="archivo_programa_evento" name="archivo_programa_evento" class="form-control"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div id="programa_download"></div>
                                    </div>
                                </div>
                                <!-- TERMINA INPUT FILE Líneas Discursivas -->

                                <!--INICIA RADIO BUTTON  Estado de la entrega de información -->
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <label for="nombrecampos"><b>Entrega de información para el mensaje:</b></label><br>
                                        </div>
                                        <div class="col-md-5 ">   


                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="entrega_informacion" id="opciones_1" value="PENDIENTE" checked="true">Pendiente
                                                </label>
                                            </div>

                                        </div>

                                        <div class="col-md-5 ">  
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="entrega_informacion" id="opciones_2" value="ENTREGADO">Entregado
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA RADIO BUTTON  Estado de la entrega de información  -->

                            </fieldset>

                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-7">
                                    <div class="btn-group" style="float:right;">
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">Cerrar</button> 
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="returnFromPrograms">Anterior</button>
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="nextFromPrograms">Siguiente</button>
                                        {!! Form::submit('Guardar',['class' => 'btn btn-success','name'=>'bttEnviarProgram'])!!}
                                        {!! Form::close() !!}
                                    </div>  
                                </div>
                            </div> 
                        </div>
                        <div id="info_requerimientos" style="display:none">
                            <center><h2>Requerimientos log&iacute;sticos</h2></center>
                            {!!Form::open(['route'=>'logistic.store','method'=>'POST','files'=>true,'id'=>'logisticsForm'])!!}
                            <input type="hidden" id="idEventLogistic" name="idEventLogistic">
                            <hr>
                            <fieldset>

                                <!-- INICIA PRESIDIUM FORMULARIO DINAMICO -->
                                <div class="row"><div class="col-sm-3"><label>Seguridad:</label></div></div>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="seguridad[]" id="seguridad_seguridad" value="seguridad">Seguridad</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="seguridad[]" id="seguridad_ambulancia" value="ambulancia">Ambulancia</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="seguridad[]" id="seguridad_bomberos" value="bomberos">Bomberos</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="seguridad[]" id="seguridad_proteccioncivil" value="proteccion_civil">Protecci&oacute;n civil</label>
                                            </div>
                                        </div>
                                    </div>

                                </div>



                                <div class="row"><div class="col-sm-3"><label>Conducci&oacute;n del evento:</label></div></div>
                                <div class="row">
                                    <div class="col-sm-2"></div>
                                    <div class="col-sm-10">
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="conduccion[]" id="conduccion_maestro" value="maestro">Maestro de ceremonias</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="conduccion[]" id="conduccion_artista" value="artista">Artista</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="conduccion[]" id="conduccion_edecanes" value="edecanes">Edecanes</label>
                                            </div>

                                        </div>
                                    </div>

                                </div>
                                <br>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group"><label>Tipo de escenario:</label></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="auditorio"><img src="{{URL::to('/')}}/img/tipo_auditorio.jpg" class="img-responsive"></label>

                                            {{ Form::radio('escenario', 'AUDITORIO', true, ['class' => 'radio','id' => 'auditorio' ]) }}

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="circular"><img src="{{URL::to('/')}}/img/tipo_circular.jpg" class="img-responsive"></label>
                                            {{ Form::radio('escenario', 'CIRCULAR', false, ['class' => 'radio','id' => 'circular' ]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="medialuna"><img src="{{URL::to('/')}}/img/tipo_medialuna.jpg" class="img-responsive"></label>
                                            {{ Form::radio('escenario','MEDIALUNA', false, ['class' => 'radio','id' => 'medialuna' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="mesarusa"><img src="{{URL::to('/')}}/img/tipo_mesarusa.jpg" class="img-responsive"></label>

                                            {{ Form::radio('escenario', 'MESARUSA', true, ['class' => 'radio','id' => 'mesarusa' ]) }}

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="mesaherradura"><img src="{{URL::to('/')}}/img/tipo_herradura.jpg" class="img-responsive"></label>

                                            {{ Form::radio('escenario', 'HERRADURA', true, ['class' => 'radio','id' => 'mesaherradura' ]) }}

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <br>
                                            <input type="radio" name="escenario"  value="0">Otro <input type="text" name="other_escenario" id="other_escenario" size="15" onkeyup="aMays(event, this);"/>

                                        </div>
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group"><label>Tipo de estrado:</label></div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="templete"><br>Templete</label>

                                            {{ Form::radio('tipo_estrado', 'TEMPLETE', true, ['class' => 'radio','id' => 'templete' ]) }}

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="mesatrabajo"><br>Mesa de trabajo</label>
                                            {{ Form::radio('tipo_estrado', 'MESATRABAJO', false, ['class' => 'radio','id' => 'mesatrabajo' ]) }}
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="piso"><br>Piso/ A pie</label>
                                            {{ Form::radio('tipo_estrado','PISO', false, ['class' => 'radio','id' => 'piso' ]) }}
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA INVITADOS E FORMULARIO DINAMICO -->
                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Recursos materiales:</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Cantidad</b></label><br>

                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Tipo</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Observaciones</b></label><br>
                                            </div>
                                        </div>
                                    </div>


                                    <div id="inputMateriales1" style="margin-bottom:4px;" class="clonedInput95" class="form-group" class="form-control">
                                        <div class="row">
                                            <div class="col-md-2 "></div>  

                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="number" id="materialesNumero1" name="materialesNumero[]" min="1" max="100000" value="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">
                                                    <select id="materialesMaterial1" name="materialesMaterial[]" class="form-control"><option value="0"> --Seleccione--</option><option value="Mesa tablón">Mesa tablón</option><option value="Sillas Plegables">Sillas Plegables</option><option value="Sillas Tiffany">Sillas Tiffany</option><option value="Sonido">Sonido</option><option value="Micros alámbricos">Micros alámbricos</option><option value="Micros inalámbricos">Micros inalámbricos</option><option value="Micros diadema">Micros diadema</option><option value="Micros lavaliere">Micros lavaliere</option><option value="Podiúm">Podiúm</option><option value="Micros lápiz">Micros lápiz</option><option value="templetes (medidas)">templetes (medidas)</option><option value="Mámparas">Mámparas</option><option value="Vinilonas">Vinilonas</option><option value="Imagen de evento">Imagen de evento</option><option value="Iluminación">Iluminación</option><option value="Sistemas avanzados sonido">Sistemas avanzados sonido</option><option value="Video proyector">Video proyector</option><option value="Pantallas de proyección">Pantallas de proyección</option><option value="Pantallas LED">Pantallas LED</option><option value="Cableado Eléctrico">Cableado Eléctrico</option><option value="Otro cableado">Otro cableado</option><option value="Coffe Break">Coffe Break</option><option value="Edecanes">Edecanes</option><option value="Plataformas">Plataformas</option><option value="Bocadillos">Bocadillos</option><option value="Papelería">Papelería</option><option value="Rafia">Rafia</option><option value="Lazo">Lazo</option><option value="carpas">carpas</option><option value="Toldos">Toldos</option><option value="Lonas/Carpa">Lonas/Carpa</option><option value="Mampara">Mampara</option><option value="Gafetes">Gafetes</option><option value="Personificadores">Personificadores</option><option value="Manteles">Manteles</option><option value="Unifilas">Unifilas</option><option value="Gallardetes">Gallardetes</option><option value="Pendones">Pendones</option><option value="Tarjetones de estacionamiento">Tarjetones de estacionamiento</option><option value="Vallas de Pánico">Vallas de Pánico</option><option value="Bolsas de resguardo (celulares)">Bolsas de resguardo (celulares)</option><option value="Desniveles">Desniveles</option><option value="Planta de Luz">Planta de Luz</option><option value="Agua">Agua</option><option value="Templete para prensa">Templete para prensa</option><option value="Leyendas de estrado">Leyendas de estrado</option><option value="Movilidad para discapacidad">Movilidad para discapacidad</option><option value="Teleprompter">Teleprompter</option><option value="iluminación templete">iluminación templete</option><option value="documento para firma">documento para firma</option><option value="Elaboración de placa">Elaboración de placa</option><option value="Honores a la bandera">Honores a la bandera</option><option value="OTRO">Otro</option></select>                                                </div>
                                            </div>
                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="text" id="materialesObservacion1" name="materialesObservacion[]" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                &nbsp&nbsp      
                                                <input type="button" class="btn btn-success" id="btnAddMaterial" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelMaterial" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA PRESIDIUM FORMULARIO DINAMICO -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_materiales">
                                                <thead>
                                                <th>Cantidad</th>
                                                <th>Material</th>
                                                <th>Observaciones</th>
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Insumos de seguridad:</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b> Cantidad</b></label><br>

                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b> Tipo</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Observaciones</b></label><br>
                                            </div>
                                        </div>

                                    </div>


                                    <div id="inputInsumos1" style="margin-bottom:4px;" class="clonedInput94" class="form-group" class="form-control">
                                        <div class="row">
                                            <div class="col-md-2 "></div>  

                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="number" id="insumosNumero1" name="insumosNumero[]" min="1" max="100000" value="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">
                                                    <select  id="insumosInsumo1" name="insumosInsumo[]" class="form-control">
                                                        <option value="0"> --Seleccione--</option>                               
                                                        <option value="ARCOS DE SEGURIDAD">Arcos de seguridad</option>
                                                        <option value="GARRETS">Garrets</option>
                                                        <option value="VALLAS DE PÁNICO">Vallas de p&aacute;nico</option>
                                                        <option value="UNIFILAS">Unifilas</option>
                                                        <option value="DESNIVELES">Desniveles</option>
                                                        <option value="BOLSAS DE RESGUARDO">Bolsas de resguardo (Celulares)</option>
                                                        <option value="OTRO">Otro</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="text" id="insumosObservaciones1" name="insumosObservaciones[]" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                <input type="button" class="btn btn-success" id="btnAddInsumo" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelInsumo" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA PRESIDIUM FORMULARIO DINAMICO -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_insumos">
                                                <thead>
                                                <th>Cantidad</th>
                                                <th>Tipo</th> 
                                                <th>Observaciones</th>  
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-md-2 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Im&aacute;gen:</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b> Cantidad</b></label><br>

                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b> Tipo</b></label><br>
                                            </div>
                                        </div>
                                        <div class="col-md-3 ">
                                            <div class="form-group">
                                                <label for="nombrecampos"><b>Observaciones</b></label><br>
                                            </div>
                                        </div>

                                    </div>


                                    <div id="inputImagen1" style="margin-bottom:4px;" class="clonedInput93" class="form-group" class="form-control">
                                        <div class="row">
                                            <div class="col-md-2 "></div>  

                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="number" id="imagenNumero1" name="imagenNumero[]" min="1" max="100000" value="1" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-md-3 "> 
                                                <div class="form-group">
                                                    <select  id="imagenImagen1" name="imagenImagen[]" class="form-control">
                                                        <option value="0"> --Seleccione--</option>                                                        <option value="PROSCENIO">Proscenio</option>
                                                        <option value="VINILONAS">Vinilonas</option>
                                                        <option value="GALLARDETES">Gallardetes</option>
                                                        <option value="PENDONES">Pendones</option>
                                                        <option value="LEYENDA DE ESTRADO">Leyenda de estrado</option>
                                                        <option value="PERSONIFICADORES">Personificadores</option>
                                                        <option value="TARJETONES DE ESTACIONAMIENTO">Tarjetones de estacionamiento</option>
                                                        <option value="OTRO">Otro</option>

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3 ">     <!--style="width: 190px;"   --> 
                                                <div class="form-group">
                                                    <input type="text" id="imagenObservaciones1" name="imagenObservaciones[]" onkeyup="aMays(event, this);" class="form-control">
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div>
                                        <div class="row">
                                            <div class="col-md-2">   </div>
                                            <div class="col-md-4 ">  
                                                <input type="button" class="btn btn-success" id="btnAddImagen" value="+" />
                                                <input type="button" class="btn btn-success" id="btnDelImagen" value="-" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- TERMINA PRESIDIUM FORMULARIO DINAMICO -->

                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="table-responsive">
                                            <table class="table table-hover" id="tabla_imagen">
                                                <thead>
                                                <th>Cantidad</th>
                                                <th>Tipo</th> 
                                                <th>Observaciones</th>  
                                                <th>Men&uacute;</th>
                                                </thead>
                                                <tbody></tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>

                                <hr>

                                <div class="row"><div class="col-sm-3"><label>Alimentos:</label></div></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="alimentos[]" id="alimentos_hidratacion" value="HIDRATACION">Puntos de hidrataci&oacute;n</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="alimentos[]" id="alimentos_coffeebreak" value="COFEE">Cofee break</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="alimentos[]" id="alimentos_bocadillos" value="BOCADILLOS">Bocadillos</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="alimentos[]" id="alimentos_agua" value="AGUA">Agua</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="alimentos[]" id="alimentos_otro" value="OTRO">Otro<input type="text" id="otro_alimento" name="otro_alimento" onkeyup="aMays(event, this);"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <hr>





                                <!-- TERMINA PRESIDIUM FORMULARIO DINAMICO -->

                                <!-- TERMINA INPUT FILE Líneas Discursivas -->

                                <!--INICIA RADIO BUTTON  Estado de la entrega de información -->

                                <!-- TERMINA RADIO BUTTON  Estado de la entrega de información  -->
                                <div class="row">
                                    <div class="col-sm-6">
                                        <p><b>Fiscalizaci&oacute;n:</b></p>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="si">Si</label>

                                            {{ Form::radio('fiscalizacion', 'SI', true, ['class' => 'radio','id' => 'si' ]) }}&nbsp;&nbsp;

                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <label for="no">No</label>
                                            {{ Form::radio('fiscalizacion', 'NO', false, ['class' => 'radio','id' => 'no' ]) }}&nbsp;&nbsp;
                                        </div>
                                    </div>

                                </div>            

                                <div class="row"><div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="responsable_comunicacion">Responsable de comunicaci&oacute;n:</label>
                                            <input type="text" class="form-control" id="responsable_comunicacion" name="responsable_comunicacion" onkeyup="aMays(event, this);">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label for="telefono_comunicacion">Tel&eacute;fono:</label>
                                            <input type="text" class="form-control" id="telefono_comunicacion" name="telefono_comunicacion" onkeypress="return justNumbers(event);" minlength="10" maxlength="10"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="row"><div class="col-sm-3"><label>Cobertura de comunicaci&oacute;n:</label></div></div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="cobertura[]" id="cobertura_pullcde" value="PULLCDE">PULL CDE</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="cobertura[]" id="cobertura_medioslocales" value="MEDIOSLOCALES">Medios locales</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="cobertura[]" id="cobertura_mediosnacionales" value="MEDIOSNACIONALES">Medios nacionales</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="cobertura[]" id="cobertura_fotografo" value="FOTOGRAFO">Fot&oacute;grafo</label>
                                            </div>
                                            <div class="checkbox-inline">
                                                <label><input type="checkbox" name="cobertura[]" id="cobertura_otro" value="OTRO">OTRO<input type="text" id="otro_cobertura" onkeyup="aMays(event, this);" name="otro_cobertura"></label>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </fieldset>

                            <hr>
                            <div class="row">
                                <div class="col-sm-5">
                                </div>
                                <div class="col-sm-7">
                                    <div class="btn-group" style="float:right;">
                                        <button type="button" 
                                                class="btn btn-default" 
                                                data-dismiss="modal">Cerrar</button> 
                                        <button type="button" 
                                                class="btn btn-default" 
                                                id="returnFromRequerimientos">Anterior</button>
                                        {!! Form::submit('Guardar',['class' => 'btn btn-success','name'=>'bttEnviarRequiriment'])!!}
                                        {!!Form::close()!!}        
                                    </div>  
                                </div>
                            </div> 
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <div id="borrarEvento" class="modal fade" role="dialog" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title" 
                            id="infoEventLabelBorrar">Borrar evento</h4>  
                    </div>
                    <div class="modal-body">
                        <center><h4 id="titulo_delete_evento">¿Seguro que deseas borrar el evento? </h4></center>
                        <center>
                            <button type="button" 
                                    class="btn btn-default btn-lg"
                                    data-dismiss="modal"
                                    id="cancelar_borrar">No&nbsp;&nbsp;&nbsp;</button>
                            <br><br>
                            <form action="{{URL::to('borrarEvento')}}" method="POST">{{ csrf_field() }}
                                <input type="hidden" id="idEventoBorrar" name="idEventoBorrar">
                                <button type="submit" class="btn btn-danger btn-lg"  title="Borrar evento" data-toggle="tooltip">Si &nbsp;<i class="fa fa-times" aria-hidden="true"></i></button>
                            </form>  
                        </center>

                    </div>

                </div>

            </div>
        </div>
        <!--div id="modalUpdate" class="modal"  aria-hidden="true">
            <div class="modal-dialog">

        <!-- Modal content-->
        <!--div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title" 
                    id="labelModalUpdate">Aviso</h4>  
            </div>
            <div class="modal-body">
                <center><h4 id="updateTitulo"></h4></center>


            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
            </div>
        </div>

    </div-->
    </div>
    <div id="snackbar"><h4 id="updateTitulo"></h4></div>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    {{Html::script('js/icheck.min.js')}}
    {{Html::script('js/validaciones.js')}}

    {{Html::script('js/moment.min.js')}}
    {{Html::script('js/daterangepicker.js')}}
    {{Html::script('js/jquery.hotkeys.js')}}
    {{Html::script('js/switchery.min.js')}}
    {{Html::script('js/blockui.js')}}
    {{Html::script('js/summernote.js')}}
    {{Html::script('js/summernote.min.js')}}
    {{Html::script('js/jquery.dataTables.min.js')}}
    {{Html::script('js/dataTables.bootstrap.min.js')}}
    {{Html::script('js/dataTables.buttons.min.js')}}
    {{Html::script('js/buttons.bootstrap.min.js')}}
    {{Html::script('js/buttons.flash.min.js')}}
    {{Html::script('js/buttons.print.min.js')}}
    {{Html::script('js/buttons.html5.min.js')}}
    {{Html::script('js/dataTables.fixedHeader.min.js')}}
    {{Html::script('js/dataTables.keyTable.min.js')}}
    {{Html::script('js/dataTables.responsive.min.js')}}
    {{Html::script('js/responsive.bootstrap.js')}}
    {{Html::script('js/dataTables.scroller.min.js')}}
    {{Html::script('clockpicker/dist/bootstrap-clockpicker.min.js')}}
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe1EXskkLEuvjNT20NBVcpH9BFTxEdpj4"
    async defer></script>



    <script>var path = "{{URL::to('/')}}"</script>
    <script>
        var map;
        var markers = [];
        var haightAshbury = {lat: 19, lng: -98.8167};
        $(document).ready(function () {
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
            "order": [ 0, 'desc' ],
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
            $('#municipio').change(function () {
                if ($('#municipio').val() != 0) {
                    searchSeccionalByMunicipio();
                } else {

                }
            });
            $("#municipio").trigger('change');
            $("img").addClass('img-responsive');
            $('#borrarEvento').on('show.bs.modal', function (event) {
                $("#infoEventLabelBorrar").html($(event.relatedTarget).data('title'));
                $("#idEventoBorrar").val($(event.relatedTarget).data('id'));
            });
            $('#infoEvent').on('show.bs.modal', function (event) {
                $("#infoEventLabel").html($(event.relatedTarget).data('title'));
                $("#fav-title").html($(event.relatedTarget).data('title'));
                $("#idEvent").val($(event.relatedTarget).data('id'));
                $.ajax({
                    url: path + '/findEventsById/' + $('#idEvent').val().trim() + '',
                    type: 'GET',
                    success: function (r) {
                        ajaxinit();
                        limpiarCampos();

                        if (r.status == true) {
                            $("#alerta_informacion").css("display", "none");
                            $("#alerta_program").css("display", "none");
                            $("#alerta_logistic").css("display", "none");
                            $("#alerta_place").css("display", "none");
                            $("#fotos_del_lugar_frente").html('');
                            $("#fotos_del_lugar_atras").html('');
                            $("#fotos_del_lugar_exterior").html('');
                            $("#foto_responsable_politico_div").html('');
                            $("#foto_responsable_operativo_div").html('');
                            $("#fotos_del_lugar_exterior").html('');
                            //$("#autoridades_del_lugar").html('');
                            //$("#comite_de_bienvenida").html('');
                            $("#programa_download").html('');
                            $("#discursivas_download").html('');
                            $("#tabla_presidium").html('');
                            $("#tabla_invitados").html('');
                            $("#tabla_lineas").html('');
                            $("#tabla_ordendia").html('');
                            $("#tabla_materiales").html('');
                            $("#tabla_imagen").html('');
                            $("#tabla_insumos").html('');

                            $("#archivo_programa_download").html('');
                            $("#nombre").val(r.evento.nombre);
                            var res = r.evento.f_inicio.split(" ");
                            var res_final = r.evento.f_final.split(" ");
                            $("#fi").val(res[0]);
                            $("#hi").val(res[1]);
                            $("#hf").val(res_final[1]);
                            $("#h_arribo").val(r.evento.hora_arribo);
                            $("#h_convocatoria").val(r.evento.hora_convocatoria);
                            $("#calle_numero").val(r.evento.calle_numero);
                            $('#seccion_impactada').html('');
                            $('#seccion_impactada').append($("<option></option>").attr("value", r.evento.seccion_impactada).text(r.evento.seccion_impactada));
                            $('#seccion_impactada').val(r.evento.seccion_impactada);
                            $("#distrito").val(r.evento.distrito_impactado);
                            $("#cp").val(r.evento.cp);
                            $("#colonia").val(r.evento.colonia);
                            $("#municipio").val(r.evento.idMunicipio);
                            $("#responsable_politico").val(r.evento.responsable_politico);
                            $("#cargo_responsable_politico").val(r.evento.cargo_responsable_politico);
                            $("#telefono_responsable_politico").val(r.evento.telefono_responsable_politico);
                            $("#email_responsable_politico").val(r.evento.email_responsable_politico);
                            $("#responsable_operativo").val(r.evento.responsable_operativo);
                            $("#cargo_responsable_operativo").val(r.evento.cargo_responsable_operativo);
                            $("#telefono_responsable_operativo").val(r.evento.telefono_responsable_operativo);
                            $("#email_responsable_operativo").val(r.evento.email_responsable_operativo);
                            $("#objetivo").val(r.evento.objetivo);
                            $("#responsable").val(r.evento.idResponsable);
                            $("#idEvento").val(r.evento.id);
                            $("#idEventLogistic").val(r.evento.id);
                            $("#lat").val(r.evento.lat);
                            $("#lng").val(r.evento.lng);
                            if (r.evento.foto_responsable_politico !== null) {
                                var elem = document.createElement("img");
                                elem.setAttribute("src", "{{ asset('uploads') }}/fotos_responsable/" + r.evento.foto_responsable_politico);
                                elem.setAttribute("height", "250px");
                                elem.setAttribute("width", "100%");
                                elem.setAttribute("alt", "Responsable político");
                                document.getElementById("foto_responsable_politico_div").appendChild(elem);
                            }

                            if (r.evento.foto_responsable_operativo !== null) {
                                var elem = document.createElement("img");
                                elem.setAttribute("src", "{{ asset('uploads') }}/fotos_responsable/" + r.evento.foto_responsable_operativo);
                                elem.setAttribute("height", "250px");
                                elem.setAttribute("width", "100%");
                                elem.setAttribute("alt", "Responsable operativo");
                                document.getElementById("foto_responsable_operativo_div").appendChild(elem);
                            }
                            $("#idEventoPlaces").val(r.evento.id);
                            $("#idEvent").val(r.evento.id);
                            $("#idEventPrograms").val(r.evento.id);
                            if (r.information == true) {
                                $('#idInformation').prop('disabled', false);
                                //$("#alerta_informacion").css("display", "none");
                                $("#idInformation").val(r.information_object.id);
                                $("input[name=tipo_evento][value=" + r.information_object.tipo_evento + "]").attr('checked', 'checked');
                                $("input[name=vestimenta][value=" + r.information_object.vestimenta + "]").attr('checked', 'checked');
                                $("input[name=rentabilidad][value=" + r.information_object.rentabilidad + "]").attr('checked', 'checked');
                                //$("#trascendencia").val(r.information_object.trascendencia);
                                $("#asistentes_aprox").val(r.information_object.asistentes);

                                $("#sugerenciavestimenta").val(r.information_object.sugerencia_vestimenta);
                                $('#participacioncandidato').append($("<option></option>").attr("value", r.information_object.participacion).text(r.information_object.participacion));
                                $("#participacioncandidato").val(r.information_object.participacion);
                                $('#sector').append($("<option></option>").attr("value", r.information_object.sector).text(r.information_object.sector));
                                $("#sector").val(r.information_object.sector);
                                $("#tema").val(r.information_object.tema);
                                $("input[name=folletos][value=" + r.information_object.folletos + "]").attr('checked', 'checked');
                                $("input[name=utilitarios][value=" + r.information_object.utilitarios + "]").attr('checked', 'checked');
                                //$("input[name=fiscalizacion][value=" + r.information_object.fiscalizacion + "]").attr('checked', 'checked');

                                /*if(r.comitereception==true){
                                 var count_comite = Object.keys(r.comitereception_object).length;
                                 $("#comite_de_bienvenida").append('<thead><th>Nombre</th><th>Cargo</th><th>Observaciones</th><th>Menú</th></thead><tbody>')
                                 for (var j = 0; j < count_comite; j++) {
                                 $("#comite_de_bienvenida").append("<tr><td>" + r.comitereception_object[j].nombre + "</td><td>" + r.comitereception_object[j].cargo + "</td><td>" + r.comitereception_object[j].nombre + "</td><td><form action='" + path + "/borrar/comitereception/" + r.comitereception_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar evento' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                 }
                                 $("#comite_de_bienvenida").append('<tbody>');
                                 }*/
                            } else {
                                $("#alerta_informacion").css("display", "block");
                                $('#idInformation').prop('disabled', true);

                            }

                            if (r.place == true) {
                                $("#alerta_place").css("display", "none");
                                if ((r.place_object.lugar !== 'ABIERTO') && (r.place_object.lugar !== 'CERRADO') && (r.place_object.lugar !== 'ESPACIO_PUBLICO') && (r.place_object.lugar !== 'ESPACIO_PRIVADO')) {
                                    $("input[name=lugar][value=" + '0' + "]").attr('checked', 'checked');
                                    $("#other_lugar").val(r.place_object.lugar);
                                } else {
                                    $("input[name=lugar][value=" + r.place_object.lugar + "]").attr('checked', 'checked');
                                }
                                $("#descripcion_lugar").val(r.place_object.descripcion);
                                if ((r.place_object.acceso_lugar !== 'EMPEDRADO') && (r.place_object.acceso_lugar !== 'PAVIMENTADO') && (r.place_object.acceso_lugar !== 'TERRACERIA')) {
                                    $("input[name=acceso_lugar][value=" + '0' + "]").attr('checked', 'checked');
                                    $("#other_acceso").val(r.place_object.acceso_lugar);
                                } else {
                                    $("input[name=acceso_lugar][value=" + r.place_object.acceso_lugar + "]").attr('checked', 'checked');
                                }
                                /*if (r.picplace == true) {
                                 var count = Object.keys(r.picplace_object).length;
                                 for (var i = 0; i < count; i++) {
                                 var elem = document.createElement("img");
                                 elem.setAttribute("src", "{{ asset('uploads') }}/" + r.picplace_object[i].url);
                                 elem.setAttribute("height", "250px");
                                 elem.setAttribute("width", "50%");
                                 elem.setAttribute("alt", "Lugar");
                                 document.getElementById("fotos_del_lugar_frente").appendChild(elem);
                                 }
                                 }
                                 if (r.bossplace == true) {
                                 var count_boss = Object.keys(r.bossplace_object).length;
                                 $("#autoridades_del_lugar").append('<thead><th>Nombre</th><th>Cargo</th><th>Observaciones</th><th>Menú</th></thead><tbody>')
                                 for (var j = 0; j < count_boss; j++) {
                                 $("#autoridades_del_lugar").append("<tr><td>" + r.bossplace_object[j].nombre + "</td><td>" + r.bossplace_object[j].cargo + "</td><td>" + r.bossplace_object[j].nombre + "</td><td><form action='" + path + "/borrar/bossplace/" + r.bossplace_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar evento' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                 }
                                 $("#autoridades_del_lugar").append('<tbody>');
                                 }*/
                                if (r.place_object.imagen_frente !== null) {
                                    var elem = document.createElement("img");
                                    elem.setAttribute("src", "{{ asset('uploads') }}/fotos_lugar/" + r.place_object.imagen_frente);
                                    elem.setAttribute("height", "250px");
                                    elem.setAttribute("width", "100%");
                                    elem.setAttribute("alt", "frente");
                                    document.getElementById("fotos_del_lugar_frente").appendChild(elem);
                                }
                                if (r.place_object.imagen_atras !== null) {
                                    var elem = document.createElement("img");
                                    elem.setAttribute("src", "{{ asset('uploads') }}/fotos_lugar/" + r.place_object.imagen_atras);
                                    elem.setAttribute("height", "250px");
                                    elem.setAttribute("width", "100%");
                                    elem.setAttribute("alt", "atras");
                                    document.getElementById("fotos_del_lugar_atras").appendChild(elem);
                                }
                                if (r.place_object.imagen_exterior !== null) {
                                    var elem = document.createElement("img");
                                    elem.setAttribute("src", "{{ asset('uploads') }}/fotos_lugar/" + r.place_object.imagen_exterior);
                                    elem.setAttribute("height", "250px");
                                    elem.setAttribute("width", "100%");
                                    elem.setAttribute("alt", "exterior");
                                    document.getElementById("fotos_del_lugar_exterior").appendChild(elem);
                                }
                                $("#riesgos_sociales").val(r.place_object.riesgos);
                                $("#problematica_politica").val(r.place_object.problematica);
                            } else {
                                $("#alerta_place").css("display", "block");
                            }
                            if (r.program == true) {
                                $("input[name=entrega_informacion][value=" + r.program_object.estado_entrega + "]").attr('checked', 'checked');
                                $('#summernote').summernote('code', r.program_object.contenido);
                                $('#summernote2').summernote('code', r.program_object.asistentes_ficha);
                                /*if(r.program_object.url_programa==null ||r.program_object.url_programa=='' ){
                                 
                                 }else{
                                 $("#archivo_programa_download").append('<a href="'+path+'uploads/discursivas/'+r.program_object.url_programa+'">Descarga de aqui el programa</a>');
                                 }  */
                                if (r.program_object.url_contenido !== null) {
                                    $("#discursivas_download").append("<a href='" + path + "/uploads/discursivas/" + r.program_object.url_contenido + "' target='_blank'>Existe un archivo click aqui para descargarlo</a>");
                                    $("#discursivas_download").append("<br><br>");
                                }
                                if (r.program_object.url_programa !== null) {
                                    $("#programa_download").append("<a href='" + path + "/uploads/discursivas/" + r.program_object.url_programa + "' target='_blank'>Existe un archivo click aqui para descargarlo</a>");
                                    $("#programa_download").append("<br><br>");
                                }
                                if (r.presidium == true) {
                                    var count_presidium = Object.keys(r.presidium_object).length;
                                    $("#tabla_presidium").append('<thead><th>Número</th><th>Nombre</th><th>Cargo</th><th>Foto</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_presidium; j++) {
                                        var foto = r.presidium_object[j].foto;
                                        if (foto == null || foto == '' || foto == ' ') {
                                            $("#tabla_presidium").append("<tr><td>" + r.presidium_object[j].numero + "</td><td>" + r.presidium_object[j].nombre + "</td><td>" + r.presidium_object[j].cargo + "</td><td>NA</td><td><form action='" + path + "/borrar/presidium/" + r.presidium_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                        } else {
                                            $("#tabla_presidium").append("<tr><td>" + r.presidium_object[j].numero + "</td><td>" + r.presidium_object[j].nombre + "</td><td>" + r.presidium_object[j].cargo + "</td><td><a target='_blank' href='" + path + "/uploads/" + r.presidium_object[j].foto + "'><img src='" + path + "/uploads/" + r.presidium_object[j].foto + "' height='80px' width='100%'></a></td><td><form action='" + path + "/borrar/presidium/" + r.presidium_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                        }
                                    }
                                    $("#tabla_presidium").append('<tbody>');
                                }
                                if (r.asistentesespeciales == true) {
                                    var count_invitados = Object.keys(r.asistentesespeciales_object).length;
                                    $("#tabla_invitados").append('<thead><th>Número</th><th>Nombre</th><th>Cargo</th><th>Foto</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_invitados; j++) {
                                        var foto = r.asistentesespeciales_object[j].foto;
                                        if (foto == null || foto == '' || foto == ' ') {
                                            $("#tabla_invitados").append("<tr><td>" + r.asistentesespeciales_object[j].numero + "</td><td>" + r.asistentesespeciales_object[j].nombre + "</td><td>" + r.asistentesespeciales_object[j].cargo + "</td><td>NA</td><td><form action='" + path + "/borrar/invitado/" + r.asistentesespeciales_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                        } else {
                                            $("#tabla_invitados").append("<tr><td>" + r.asistentesespeciales_object[j].numero + "</td><td>" + r.asistentesespeciales_object[j].nombre + "</td><td>" + r.asistentesespeciales_object[j].cargo + "</td><td><a target='_blank' href='" + path + "/uploads/" + r.asistentesespeciales_object[j].foto + "'><img src='" + path + "/uploads/" + r.asistentesespeciales_object[j].foto + "' height='80px' width='100%'></a></td><td><form action='" + path + "/borrar/invitado/" + r.asistentesespeciales_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");
                                        }
                                    }
                                    $("#tabla_invitados").append('<tbody>');
                                }
                                if (r.primeraslineas == true) {
                                    var count_lineas = Object.keys(r.primeraslineas_object).length;
                                    $("#tabla_lineas").append('<thead><th>Orden</th><th>Nombre</th><th>Justificación</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_lineas; j++) {
                                        $("#tabla_lineas").append("<tr><td>" + r.primeraslineas_object[j].numero + "</td><td>" + r.primeraslineas_object[j].nombre + "</td><td>" + r.primeraslineas_object[j].justificacion + "</td><td><form action='" + path + "/borrar/primeralinea/" + r.primeraslineas_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");

                                    }
                                    $("#tabla_lineas").append('<tbody>');
                                }
                                if (r.ordenesdia == true) {
                                    var count_ordenes = Object.keys(r.ordenesdia_object).length;
                                    $("#tabla_ordendia").append('<thead><th>N.P</th><th>Intervención</th><th>Cargo</th><th>Duración (minutos)</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_ordenes; j++) {
                                        $("#tabla_ordendia").append("<tr><td>" + r.ordenesdia_object[j].np + "</td><td>" + r.ordenesdia_object[j].intervencion + "</td><td>" + r.ordenesdia_object[j].cargo + "</td><td>" + r.ordenesdia_object[j].minutos + "</td><td><form action='" + path + "/borrar/ordendia/" + r.ordenesdia_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");

                                    }
                                    $("#tabla_ordendia").append('<tbody>');
                                }

                            } else {
                                $("#alerta_program").css("display", "block");
                            }

                            if (r.logistic == true) {
                                if (r.logistic_object.seguridad == 1) {
                                    $('#seguridad_seguridad').prop('checked', true);
                                }
                                if (r.logistic_object.ambulancia == 1) {
                                    $('#seguridad_ambulancia').prop('checked', true);
                                }
                                if (r.logistic_object.bomberos == 1) {
                                    $('#seguridad_bomberos').prop('checked', true);
                                }
                                if (r.logistic_object.proteccion_civil == 1) {
                                    $('#seguridad_proteccioncivil').prop('checked', true);
                                }

                                if (r.logistic_object.maestro_ceremonias == 1) {
                                    $('#conduccion_maestro').prop('checked', true);
                                }
                                if (r.logistic_object.artista == 1) {
                                    $('#conduccion_artista').prop('checked', true);
                                }
                                if (r.logistic_object.edecanes == 1) {
                                    $('#conduccion_edecanes').prop('checked', true);
                                }

                                if ((r.logistic_object.tipo_escenario !== 'AUDITORIO') && (r.logistic_object.tipo_escenario !== 'CIRCULAR') && (r.logistic_object.tipo_escenario !== 'MEDIALUNA') && (r.logistic_object.tipo_escenario !== 'MESARUSA') && (r.logistic_object.tipo_escenario !== 'HERRADURA')) {
                                    $("input[name=escenario][value=" + '0' + "]").attr('checked', 'checked');
                                    $("#other_escenario").val(r.logistic_object.tipo_escenario);
                                } else {
                                    $("input[name=escenario][value=" + r.logistic_object.tipo_escenario + "]").attr('checked', 'checked');
                                }

                                $("input[name=tipo_estrado][value=" + r.logistic_object.tipo_estrado + "]").attr('checked', 'checked');

                                if (r.logistic_object.hidratacion == 1) {
                                    $('#alimentos_hidratacion').prop('checked', true);
                                }
                                if (r.logistic_object.coffeebreak == 1) {
                                    $('#alimentos_coffeebreak').prop('checked', true);
                                }
                                if (r.logistic_object.bocadillos == 1) {
                                    $('#alimentos_bocadillos').prop('checked', true);
                                }
                                if (r.logistic_object.agua == 1) {
                                    $('#alimentos_agua').prop('checked', true);
                                }
                                if (r.logistic_object.otro_alimento !== null) {
                                    $('#alimentos_otro').prop('checked', true);
                                    $('#otro_alimento').val(r.logistic_object.otro_alimento);
                                }
                                $("input[name=fiscalizacion][value=" + r.logistic_object.fiscalizacion + "]").attr('checked', 'checked');

                                $("#responsable_comunicacion").val(r.logistic_object.responsable_comunicacion);
                                $("#telefono_comunicacion").val(r.logistic_object.telefono_comunicacion);
                                if (r.logistic_object.pull_cde == 1) {
                                    $('#cobertura_pullcde').prop('checked', true);
                                }
                                if (r.logistic_object.medios_locales == 1) {
                                    $('#cobertura_medioslocales').prop('checked', true);
                                }
                                if (r.logistic_object.medios_nacionales == 1) {
                                    $('#cobertura_mediosnacionales').prop('checked', true);
                                }
                                if (r.logistic_object.fotografo == 1) {
                                    $('#cobertura_fotografo').prop('checked', true);
                                }
                                if (r.logistic_object.otro_medio !== null) {
                                    $('#cobertura_otro').prop('checked', true);
                                    $('#otro_cobertura').val(r.logistic_object.otro_alimento);
                                }
                                if (r.materialresources == true) {
                                    var count_presidium = Object.keys(r.materialresources_object).length;
                                    $("#tabla_materiales").append('<thead><th>Cantidad</th><th>Material</th><th>Observaciones</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_presidium; j++) {
                                        $("#tabla_materiales").append("<tr><td>" + r.materialresources_object[j].cantidad + "</td><td>" + r.materialresources_object[j].tipo + "</td><td>" + r.materialresources_object[j].observaciones + "</td><td><form action='" + path + "/borrar/materialresources/" + r.materialresources_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");

                                    }
                                }
                                if (r.imageresources == true) {
                                    var count_presidium = Object.keys(r.imageresources_object).length;
                                    $("#tabla_imagen").append('<thead><th>Cantidad</th><th>Material</th><th>Observaciones</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_presidium; j++) {
                                        $("#tabla_imagen").append("<tr><td>" + r.imageresources_object[j].cantidad + "</td><td>" + r.imageresources_object[j].tipo + "</td><td>" + r.imageresources_object[j].observaciones + "</td><td><form action='" + path + "/borrar/imageresources/" + r.imageresources_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");

                                    }
                                }
                                if (r.securitysupplies == true) {
                                    var count_presidium = Object.keys(r.securitysupplies_object).length;
                                    $("#tabla_insumos").append('<thead><th>Cantidad</th><th>Material</th><th>Observaciones</th><th>Menú</th></thead><tbody>')
                                    for (var j = 0; j < count_presidium; j++) {
                                        $("#tabla_insumos").append("<tr><td>" + r.securitysupplies_object[j].cantidad + "</td><td>" + r.securitysupplies_object[j].tipo + "</td><td>" + r.securitysupplies_object[j].observaciones + "</td><td><form action='" + path + "/borrar/securitysupplies/" + r.securitysupplies_object[j].id + "' method='GET'><button type='submit' class='btn btn-danger' title='Borrar' data-toggle='tooltip'>Borrar &nbsp;<i class='fa fa-times' aria-hidden='true'></i></button></form></td></tr>");

                                    }
                                }
                            } else {
                                $("#alerta_logistic").css("display", "block");
                            }
                            cargarMapa();
                            ajaxend();
                        }
                    }
                    , error: function (XMLHttpRequest, textStatus, errorThrown) {
                    }
                });
            });

            $('.calendario').daterangepicker({
                locale: {
                    format: 'DD/MMM/YYYY'
                },
                singleDatePicker: true,
                calender_style: "picker_4",
            }, function (start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
            });
            $("#participacioncandidato").change(function () {

                if ($("#participacioncandidato").val() != '0') {
                    $("#otro_div_participacion").css("display", "none");
                } else {
                    $("#otro_div_participacion").css("display", "block");
                }
            });
            $("#sector").change(function () {

                if ($("#sector").val() != '0') {
                    $("#otro_div_sector").css("display", "none");
                } else {
                    $("#otro_div_sector").css("display", "block");
                }
            });
            $("#firstSteep").click(function () {
                $("#info_general").css("display", "none");
                $("#info_territorial").css("display", "block");
                $("#infoEvent").scrollTop(0);

            });
            $("#secondSteep").click(function () {
                $("#info_general").css("display", "block");
                $("#info_territorial").css("display", "none");
                $("#infoEvent").scrollTop(0);
            });
            $("#thirdSteep").click(function () {
                $("#info_territorial").css("display", "none");
                $("#info_places").css("display", "block");
                $("#infoEvent").scrollTop(0);
            });
            $("#returnSecondSteep").click(function () {
                $("#info_territorial").css("display", "block");
                $("#info_places").css("display", "none");
                $("#infoEvent").scrollTop(0);
            });
            $("#returnFromPrograms").click(function () {
                $("#info_programs").css("display", "none");
                $("#info_places").css("display", "block");
                $("#infoEvent").scrollTop(0);
            });
            $("#nextFromPlaces").click(function () {
                $("#info_places").css("display", "none");
                $("#info_programs").css("display", "block");
                $("#infoEvent").scrollTop(0);
            });

            $("#nextFromPrograms").click(function () {
                $("#info_requerimientos").css("display", "block");
                $("#info_programs").css("display", "none");
                $("#infoEvent").scrollTop(0);
            });
            $("#returnFromRequerimientos").click(function () {
                $("#info_requerimientos").css("display", "none");
                $("#info_programs").css("display", "block");
                $("#infoEvent").scrollTop(0);
            });

            $('#infoEvent').on('hidden.bs.modal', function () {
                $("#info_requerimientos").css("display", "none");
                $("#info_programs").css("display", "none");
                $("#info_places").css("display", "none");
                $("#info_territorial").css("display", "none");
                $("#info_general").css("display", "block");
            });
            /*$('#btnAddAutoridadeslugar').click(function () {
             var numAutoridadeslugar = $('.clonedInput').length;
             var newNumAutoridadeslugar = new Number(numAutoridadeslugar + 1);
             
             var newElemAutoridadeslugar = $('#inputAutoridadeslugar' + numAutoridadeslugar).clone().attr('id', 'inputAutoridadeslugar' + newNumAutoridadeslugar);
             
             newElemAutoridadeslugar.children(':first').prop('id', 'AutoridadeslugarNombre' + newNumAutoridadeslugar).attr('name', 'AutoridadeslugarNombre[]');
             newElemAutoridadeslugar.children(':eq(1)').prop('id', 'AutoridadeslugarCargo' + newNumAutoridadeslugar).attr('name', 'AutoridadeslugarCargo[]');
             newElemAutoridadeslugar.children(':last').prop('id', 'AutoridadeslugarObservaciones' + newNumAutoridadeslugar).attr('name', 'AutoridadeslugarObservaciones[]');
             $('#inputAutoridadeslugar' + numAutoridadeslugar).after(newElemAutoridadeslugar);
             $('#btnDelAutoridadeslugar').prop('disabled', '');
             
             //if (newNumAutoridadeslugar == 99) esto es por si sequiere limitar la cantidad de los forms creados
             // $('#btnAddAutoridadeslugar').attr('disabled','disabled');
             });
             
             $('#btnDelAutoridadeslugar').click(function () {
             var numAutoridadeslugar = $('.clonedInput').length;
             
             $('#inputAutoridadeslugar' + numAutoridadeslugar).remove();
             $('#btnAddAutoridadeslugar').prop('disabled', '');
             
             if (numAutoridadeslugar - 1 == 1)
             $('#btnDelAutoridadeslugar').prop('disabled', 'disabled');
             });
             
             $('#btnDelAutoridadeslugar').prop('disabled', 'disabled');
             */
            $("input:radio[name='lugar']").change(function () {
                if ($(this).val() == "ESPACIO_PUBLICO") {
                    $("#nota_publico").css("display", "block");
                } else {
                    $("#nota_publico").css("display", "none");
                }
            });
            //INICIA CODIGO PARA FORMULARIO DINAMICO PRESIDIUM
            $('#btnAddPresidium').click(function () {
                var numPresidium = $('.clonedInput99').length;
                var newNumPresidium = new Number(numPresidium + 1);

                var newElemPresidium = $('#inputPresidium' + numPresidium).clone().attr('id', 'inputPresidium' + newNumPresidium);

                newElemPresidium.children(':first').attr('id', 'PresidiumNumero' + newNumPresidium).attr('name', 'PresidiumNumero[]');
                newElemPresidium.children(':eq(1)').attr('id', 'PresidiumNombre' + newNumPresidium).attr('name', 'PresidiumNombre[]');
                newElemPresidium.children(':eq(2)').attr('id', 'PresidiumCargo' + newNumPresidium).attr('name', 'PresidiumCargo[]');
                newElemPresidium.children(':last').attr('id', 'PresidiumFoto' + newNumPresidium).attr('name', 'PresidiumFoto[]');
                newElemPresidium.find('input,file').val('');
                $('#inputPresidium' + numPresidium).after(newElemPresidium);
                $("#btnDelPresidium").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelPresidium').click(function () {
                var numPresidium = $('.clonedInput99').length;

                $('#inputPresidium' + numPresidium).remove();
                $("#btnAddPresidium").prop('disabled', false);

                if (numPresidium - 1 == 1)
                    $("#btnDelPresidium").prop('disabled', true);
            });
            $("#btnDelPresidium").prop('disabled', true);
            //TERMINA CODIGO PARA FORMULARIO DINAMICO PRESIDIUM
            //INICIA CODIGO PARA FORMULARIO DINAMICO comite bienvenida
            /* $('#btnAddComitebienvenida').click(function () {
             var numComitebienvenida = $('.clonedInput98').length;
             var newNumComitebienvenida = new Number(numComitebienvenida + 1);
             
             var newElemComitebienvenida = $('#inputComitebienvenida' + numComitebienvenida).clone().attr('id', 'inputComitebienvenida' + newNumComitebienvenida);
             
             newElemComitebienvenida.children(':first').attr('id', 'ComitebienvenidaNumero' + newNumComitebienvenida).attr('name', 'ComitebienvenidaNumero[]');
             newElemComitebienvenida.children(':eq(1)').attr('id', 'ComitebienvenidaNombre' + newNumComitebienvenida).attr('name', 'ComitebienvenidaNombre[]');
             newElemComitebienvenida.children(':last').attr('id', 'ComitebienvenidaCargo' + newNumComitebienvenida).attr('name', 'ComitebienvenidaCargo[]');
             $('#inputComitebienvenida' + numComitebienvenida).after(newElemComitebienvenida);
             $("#btnDelComitebienvenida").prop('disabled', false);
             
             //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
             // $('#btnAddPresidium').attr('disabled','disabled');
             });
             
             $('#btnDelComitebienvenida').click(function () {
             var numComitebienvenida = $('.clonedInput98').length;
             
             $('#inputComitebienvenida' + numComitebienvenida).remove();
             $("#btnAddComitebienvenida").prop('disabled', false);
             
             if (numComitebienvenida - 1 == 1)
             $("#btnDelComitebienvenida").prop('disabled', true);
             });
             $("#btnDelComitebienvenida").prop('disabled', true);*/
            //TERMINA CODIGO PARA FORMULARIO DINAMICO comite bienvenida
            //INICIA CODIGO PARA FORMULARIO DINAMICO INVITADOS ESPECIALES
            $('#btnAddInvitadosE').click(function () {
                var numInvitadosE = $('.clonedInput2').length;
                var newNumInvitadosE = new Number(numInvitadosE + 1);

                var newElemInvitadosE = $('#inputInvitadosE' + numInvitadosE).clone().attr('id', 'inputInvitadosE' + newNumInvitadosE);

                newElemInvitadosE.children(':first').attr('id', 'InvitadosENumero' + newNumInvitadosE).attr('name', 'InvitadosENumero[]');
                newElemInvitadosE.children(':eq(1)').attr('id', 'InvitadosENombre' + newNumInvitadosE).attr('name', 'InvitadosENombre[]');
                newElemInvitadosE.children(':eq(2)').attr('id', 'InvitadosECargo' + newNumInvitadosE).attr('name', 'InvitadosECargo[]');
                newElemInvitadosE.children(':last').attr('id', 'InvitadosEFoto' + newNumInvitadosE).attr('name', 'InvitadosEFoto[]');
                newElemInvitadosE.find('input,file').val('');
                $('#inputInvitadosE' + numInvitadosE).after(newElemInvitadosE);
                $("#btnDelInvitadosE").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelInvitadosE').click(function () {
                var numInvitadosE = $('.clonedInput2').length;

                $('#inputInvitadosE' + numInvitadosE).remove();
                $("#btnDelInvitadosE").prop('disabled', false);

                if (numInvitadosE - 1 == 1)
                    $("#btnDelInvitadosE").prop('disabled', true);
            });
            $("#btnDelInvitadosE").prop('disabled', true);
            //TERMINA CODIGO PARA FORMULARIO DINAMICO INVITADOS ESPECIALES


            //INICIA CODIGO PARA FORMULARIO DINAMICO ORDEN DEL DIA
            $('#btnAddOrdenDia').click(function () {
                var numOrdenDia = $('.clonedInput3').length;
                var newNumOrdenDia = new Number(numOrdenDia + 1);

                var newElemOrdenDia = $('#inputOrdenDia' + numOrdenDia).clone().attr('id', 'inputOrdenDia' + newNumOrdenDia);

                newElemOrdenDia.children(':first').attr('id', 'OrdenDiaNumero' + newNumOrdenDia).attr('name', 'OrdenDiaNumero[]');
                newElemOrdenDia.children(':eq(1)').attr('id', 'OrdenDiaIntervencion' + newNumOrdenDia).attr('name', 'OrdenDiaIntervencion[]');
                newElemOrdenDia.children(':eq(2)').attr('id', 'OrdenDiaCargo' + newNumOrdenDia).attr('name', 'OrdenDiaCargo[]');
                newElemOrdenDia.children(':last').attr('id', 'OrdenDiaDuracion' + newNumOrdenDia).attr('name', 'OrdenDiaDuracion[]');
                newElemOrdenDia.find('input').val('');
                $('#inputOrdenDia' + numOrdenDia).after(newElemOrdenDia);
                $("#btnDelOrdenDia").prop('disabled', false);

                //if (newNumOrdenDia == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddOrdenDia').attr('disabled','disabled');
            });

            $('#btnDelOrdenDia').click(function () {
                var numOrdenDia = $('.clonedInput3').length;

                $('#inputOrdenDia' + numOrdenDia).remove();
                $("#btnAddOrdenDia").prop('disabled', false);

                if (numOrdenDia - 1 == 1)
                    $("#btnDelOrdenDia").prop('disabled', true);
            });
            $("#btnDelOrdenDia").prop('disabled', true);
            //TERMINA CODIGO PARA FORMULARIO DINAMICO ORDEN DEL DIA
            //INICIA CODIGO PARA FORMULARIO DINAMICO comite bienvenida
            $('#btnAddPrimeraslineas').click(function () {
                var numPrimeraslineas = $('.clonedInput97').length;
                var newNumPrimeraslineas = new Number(numPrimeraslineas + 1);

                var newElemPrimeraslineas = $('#inputPrimeraslineas' + numPrimeraslineas).clone().attr('id', 'inputPrimeraslineas' + newNumPrimeraslineas);

                newElemPrimeraslineas.children(':first').attr('id', 'PrimeraslineasNumero' + newNumPrimeraslineas).attr('name', 'PrimeraslineasNumero[]');
                newElemPrimeraslineas.children(':eq(1)').attr('id', 'PrimeraslineasNombre' + newNumPrimeraslineas).attr('name', 'PrimeraslineasNombre[]');
                newElemPrimeraslineas.children(':last').attr('id', 'PrimeraslineasJustificacion' + newNumPrimeraslineas).attr('name', 'PrimeraslineasJustificacion[]');
                newElemPrimeraslineas.find('input').val('');
                $('#inputPrimeraslineas' + numPrimeraslineas).after(newElemPrimeraslineas);
                $("#btnDelPrimeraslineas").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelPrimeraslineas').click(function () {
                var numPrimeraslineas = $('.clonedInput97').length;

                $('#inputPrimeraslineas' + numPrimeraslineas).remove();
                $("#btnAddPrimeraslineas").prop('disabled', false);

                if (numPrimeraslineas - 1 == 1)
                    $("#btnDelPrimeraslineas").prop('disabled', true);
            });
            $("#btnDelPrimeraslineas").prop('disabled', true);
            //TERMINA CODIGO PARA FORMULARIO DINAMICO comite bienvenida
            $('#btnAddMaterial').click(function () {
                var numMaterial = $('.clonedInput95').length;
                var newNumMaterial = new Number(numMaterial + 1);

                var newElemMaterial = $('#inputMateriales' + numMaterial).clone().attr('id', 'inputMateriales' + newNumMaterial);

                newElemMaterial.children(':first').attr('id', 'materialesNumero' + newNumMaterial).attr('name', 'materialesNumero[]');
                newElemMaterial.children(':eq(1)').attr('id', 'materialesMaterial' + newNumMaterial).attr('name', 'materialesMaterial[]');
                newElemMaterial.children(':last').attr('id', 'materialesObservacion' + newNumMaterial).attr('name', 'materialesObservacion[]');
                newElemMaterial.find('input').val('');
                newElemMaterial.find('select').val('0');

                $('#inputMateriales' + numMaterial).after(newElemMaterial);
                $("#btnDelMaterial").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelMaterial').click(function () {
                var numMaterial = $('.clonedInput95').length;

                $('#inputMateriales' + numMaterial).remove();
                $("#btnAddMaterial").prop('disabled', false);

                if (numMaterial - 1 == 1)
                    $("#btnDelMaterial").prop('disabled', true);
            });
            $("#btnDelMaterial").prop('disabled', true);



            $('#btnAddInsumo').click(function () {
                var numMaterial = $('.clonedInput94').length;
                var newNumMaterial = new Number(numMaterial + 1);

                var newElemMaterial = $('#inputInsumos' + numMaterial).clone().attr('id', 'inputInsumos' + newNumMaterial);

                newElemMaterial.children(':first').attr('id', 'insumosNumero' + newNumMaterial).attr('name', 'insumosNumero[]');
                newElemMaterial.children(':eq(1)').attr('id', 'insumosInsumo' + newNumMaterial).attr('name', 'insumosInsumo[]');
                newElemMaterial.children(':last').attr('id', 'insumosObservaciones' + newNumMaterial).attr('name', 'insumosObservaciones[]');
                newElemMaterial.find('input').val('');
                newElemMaterial.find('select').val('0');
                $('#inputInsumos' + numMaterial).after(newElemMaterial);
                $("#btnDelInsumo").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelInsumo').click(function () {
                var numMaterial = $('.clonedInput94').length;

                $('#inputInsumos' + numMaterial).remove();
                $("#btnAddInsumo").prop('disabled', false);

                if (numMaterial - 1 == 1)
                    $("#btnDelInsumo").prop('disabled', true);
            });
            $("#btnDelInsumo").prop('disabled', true);

            $('#btnAddImagen').click(function () {
                var numMaterial = $('.clonedInput93').length;
                var newNumMaterial = new Number(numMaterial + 1);

                var newElemMaterial = $('#inputImagen' + numMaterial).clone().attr('id', 'inputImagen' + newNumMaterial);

                newElemMaterial.children(':first').attr('id', 'imagenNumero' + newNumMaterial).attr('name', 'imagenNumero[]');
                newElemMaterial.children(':eq(1)').attr('id', 'imagenImagen' + newNumMaterial).attr('name', 'imagenImagen[]');
                newElemMaterial.children(':last').attr('id', 'imagenObservaciones' + newNumMaterial).attr('name', 'imagenObservaciones[]');
                newElemMaterial.find('input').val('');
                newElemMaterial.find('select').val('0');
                $('#inputImagen' + numMaterial).after(newElemMaterial);
                $("#btnDelImagen").prop('disabled', false);

                //if (newNumPresidium == 99) esto es por si sequiere limitar la cantidad de los forms creados
                // $('#btnAddPresidium').attr('disabled','disabled');
            });

            $('#btnDelImagen').click(function () {
                var numMaterial = $('.clonedInput93').length;

                $('#inputImagen' + numMaterial).remove();
                $("#btnAddImagen").prop('disabled', false);

                if (numMaterial - 1 == 1)
                    $("#btnDelImagen").prop('disabled', true);
            });
            $("#btnDelImagen").prop('disabled', true);
            //define que las imagenes sean responsivas y el tamaño default de las imagenes que en realidad no se si se respete en todos los navegadores

            $("img").addClass("img-responsive");
            $("img").height(100);
            $("img").width(100);

            //inicia la configuracion del summernote editor
            $('#summernote').summernote({
                height: 150, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true, // set focus to editable area after initializing summernote
                dialogsFade: true,
                fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
                toolbar: [
                    //['fontname', ['fontname']],
                    //['fontsize', ['fontsize']],
                    // ['font', ['style', 'bold', 'italic', 'underline', 'clear']],
                    //['color', ['color']],
                    ['para', ['ul']],
                            //['height', ['height']],
                            //['table', ['table']],
                            //['insert', ['link']],
                            //['view', ['fullscreen', 'codeview']],
                            //['misc', ['undo', 'redo']]
                ]
            });
            $('#summernote2').summernote({
                height: 150, // set editor height
                minHeight: null, // set minimum height of editor
                maxHeight: null, // set maximum height of editor
                focus: true, // set focus to editable area after initializing summernote
                dialogsFade: true,
                fontNames: ['Roboto Light', 'Roboto Regular', 'Roboto Bold'],
                toolbar: [
                    //['fontname', ['fontname']],
                    //['fontsize', ['fontsize']],
                    // ['font', ['style', 'bold', 'italic', 'underline', 'clear']],
                    //['color', ['color']],
                    ['para', ['ul']],
                            //['height', ['height']],
                            //['table', ['table']],
                            //['insert', ['link']],
                            //['view', ['fullscreen', 'codeview']],
                            //['misc', ['undo', 'redo']]
                ]
            });

            $("#editarBaseEvent").submit(function () {
                var formObj = $(this);
                var formData = new FormData(this);
                var url = path + "/evento/editarEventoBase";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // de forma seriada los elementos del form
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r)
                    {
                        var r = $.parseJSON(r);
                        if (r.status == true) {
                            $("#updateTitulo").text("Se guardo con exito!");

                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        } else {
                            $("#updateTitulo").text("Ocurrio un error al actualizar, intente de nuevo mas tarde.");
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });

                return false; // evitar la ejecucion del form si algo falla
            });
            $("#formInformation").submit(function () {
                var formObj = $(this);
                var formData = new FormData(this);
                var url = path + "/informations/store";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // de forma seriada los elementos del form
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r)
                    {
                        var r = $.parseJSON(r);
                        if (r.status == true) {
                            $("#updateTitulo").text('Se guardaron los cambios con exito!');
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        } else {
                            $("#updateTitulo").text("Ocurrio un error al actualizar, intente de nuevo mas tarde.");
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });

                return false; // evitar la ejecucion del form si algo falla
            });

            $("#placesForm").submit(function () {
                var formObj = $(this);
                var formData = new FormData(this);
                var url = path + "/places/store";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // de forma seriada los elementos del form
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r)
                    {
                        var r = $.parseJSON(r);
                        if (r.status == true) {
                            $("#updateTitulo").text('Se guardaron los cambios con exito!');
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        } else {
                            $("#updateTitulo").text("Ocurrio un error al actualizar, intente de nuevo mas tarde.");
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });

                return false; // evitar la ejecucion del form si algo falla
            });
            $("#programForm").submit(function () {
                var formObj = $(this);
                var formData = new FormData(this);
                var url = path + "/programs/store";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // de forma seriada los elementos del form
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r)
                    {
                        var r = $.parseJSON(r);
                        if (r.status == true) {
                            $("#updateTitulo").text('Se guardaron los cambios con exito!');
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                            limpiarCamposEspeciales();
                        } else {
                            $("#updateTitulo").text("Ocurrio un error al actualizar, intente de nuevo mas tarde.");
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });

                return false; // evitar la ejecucion del form si algo falla
            });
            $("#logisticsForm").submit(function () {
                var formObj = $(this);
                var formData = new FormData(this);
                var url = path + "/logistic/store";

                $.ajax({
                    type: "POST",
                    url: url,
                    data: formData, // de forma seriada los elementos del form
                    mimeType: "multipart/form-data",
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function (r)
                    {
                        var r = $.parseJSON(r);
                        if (r.status == true) {
                            $("#updateTitulo").text('Se guardaron los cambios con exito!');
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                            limpiarCamposEspeciales();
                        } else {
                            $("#updateTitulo").text("Ocurrio un error al actualizar, intente de nuevo mas tarde.");
                            var x = document.getElementById("snackbar");

// Add the "show" class to DIV
                            x.className = "show";

// After 3 seconds, remove the show class from DIV
                            setTimeout(function () {
                                x.className = x.className.replace("show", "");
                            }, 3000);
                        }

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        alert("Status: " + textStatus);
                        alert("Error: " + errorThrown);
                    }
                });

                return false; // evitar la ejecucion del form si algo falla
            });



        });
        let options =
                {
                    donetext: 'Done',
                    placement: 'bottom',
                    align: 'left'
                }
        $('.clockpicker').clockpicker(options);
        $(document).ajaxStart(function () {
            ajaxinit();
        });

        $(document).ajaxStop(function () {
            ajaxend();
        });

        function ajaxinit() {
            $.blockUI({css: {backgroundColor: 'transparent', border: 'none', color: '#fff', filter: 'alpha(opacity=50)', opacity: '.5'}, message: '<center><img src="http://factura.parkblack.com/images/ajax-loader.gif"></center>', baseZ: 1100});
        }
        function ajaxend() {
            $.unblockUI();
        }
        function cargarMapa() {

            var location = {lat: parseFloat($("#lat").val()), lng: parseFloat($("#lng").val())};

            map = new google.maps.Map(document.getElementById('map'), {
                zoom: 17,
                center: location,
                mapTypeId: google.maps.MapTypeId.TERRAIN
            });
            google.maps.event.addListener(map, "idle", function () {
                google.maps.event.trigger(map, 'resize');
            });
            // This event listener will call addMarker() when the map is clicked.
            map.addListener('click', function (event) {
                clearMarkers();
                markers = [];
                addMarker(event.latLng);
                $('#lat').val(event.latLng.lat());
                $('#lng').val(event.latLng.lng());
            });

            // Adds a marker at the center of the map.
            addMarker(location);
        }

        // Adds a marker to the map and push to the array.
        function addMarker(location) {
            var marker = new google.maps.Marker({
                position: location,
                map: map
            });

            markers.push(marker);
        }

        // Sets the map on all markers in the array.
        function setMapOnAll(map) {
            for (var i = 0; i < markers.length; i++) {
                markers[i].setMap(map);
            }
        }

        // Removes the markers from the map, but keeps them in the array.
        function clearMarkers() {
            setMapOnAll(null);
        }

        // Shows any markers currently in the array.
        function showMarkers() {
            setMapOnAll(map);
        }

        // Deletes all markers in the array by removing references to them.
        function deleteMarkers() {
            clearMarkers();
            markers = [];
        }
        function codeAddress() {
            var geocoder = new google.maps.Geocoder();

            var address = $("#calle_numero").val() + " " + $("#municipio option:selected").text() + ", Estado de Mexico " + $("#cp").val();
            geocoder.geocode({'address': address}, function (results, status) {

                if (status == google.maps.GeocoderStatus.OK) {
                    clearMarkers();
                    markers = [];
                    map.setCenter(results[0].geometry.location);

                    var marker = new google.maps.Marker({
                        map: map,
                        position: results[0].geometry.location
                    });
                    markers.push(marker);
                    $('#lat').val(results[0].geometry.location.lat());
                    $('#lng').val(results[0].geometry.location.lng());

                } else {
                    alert("No se encontro la dirección escrita")
                }
            });
        }
        function searchSeccionalByMunicipio() {


            $.ajax({
                type: "GET",
                url: path + "/findSeccionalByMunicipio/" + $('#municipio').val().trim() + "",
                success: function (r)
                {
                    if (r.status != false) {

                        $("#seccion_impactada").html('');

                        var i = 0;
                        for (i = 0; i < r.seccionales.length; i++) {
                            $("#seccion_impactada").append('<option value="' + r.seccionales[i] + '">' + r.seccionales[i] + '</option>');
                        }
                    } else {
                        $("#seccion_impactada").html('');
                        alert("No existen seccionales disponibles");
                        return;
                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    alert("Status: " + textStatus);
                    alert("Error: " + errorThrown);
                }
            });
        }

        function limpiarCampos() {
            $("#h_arribo").val('');
            $("#h_convocatoria").val('');
            $("#calle_numero").val('');

            $('#seccion_impactada').val('');
            $("#distrito").val('');
            $("#cp").val('');
            $("#colonia").val('');
            $("#municipio").val('');
            $("#responsable_politico").val('');
            $("#cargo_responsable_politico").val('');
            $("#telefono_responsable_politico").val('');
            $("#email_responsable_politico").val('');
            $("#responsable_operativo").val('');
            $("#cargo_responsable_operativo").val('');
            $("#telefono_responsable_operativo").val('');
            $("#email_responsable_operativo").val('');
            $("#objetivo").val('');
            $("#responsable").val('');
            $("#idEvento").val('');
            $("#idEventLogistic").val('');
            $("#lat").val('');
            $("#lng").val('');
            $("#idEventoPlaces").val('');
            $("#idEvent").val('');
            $("#idEventPrograms").val('');
            $("#asistentes_aprox").val('');

            $("#sugerenciavestimenta").val('');

            $("#participacioncandidato").val('');

            $("#sector").val('');
            $("#tema").val('');
            $("#descripcion_lugar").val('');
            $("#riesgos_sociales").val('');
            $("#problematica_politica").val('');
            $('#summernote').summernote('code', '');
            $('#summernote2').summernote('code', '');
            $('#seguridad_seguridad').prop('checked', false);
            $('#seguridad_ambulancia').prop('checked', false);
            $('#seguridad_bomberos').prop('checked', false);
            $('#seguridad_proteccioncivil').prop('checked', false);
            $('#conduccion_maestro').prop('checked', false);
            $('#conduccion_artista').prop('checked', false);
            $('#conduccion_edecanes').prop('checked', false);
            $('#alimentos_hidratacion').prop('checked', false);
            $('#alimentos_coffeebreak').prop('checked', false);
            $('#alimentos_bocadillos').prop('checked', false);
            $('#alimentos_agua').prop('checked', false);
            $('#alimentos_otro').prop('checked', false);
            $('#otro_alimento').val('');
            $("#responsable_comunicacion").val('');
            $("#telefono_comunicacion").val('');
            $('#cobertura_pullcde').prop('checked', false);
            $('#cobertura_medioslocales').prop('checked', false);
            $('#cobertura_mediosnacionales').prop('checked', false);
            $('#cobertura_fotografo').prop('checked', false);
            $('#cobertura_otro').prop('checked', false);
            $('#otro_cobertura').val('');
            $("#other_lugar").val('');
            $("#other_acceso").val('');
            limpiarCamposEspeciales();
        }

        function checkFormInfoGeneral(form)
        {
            //
            // validate form fields
            //

            form.bttEnviarInfoGeneral.disabled = true;
            return true;
        }
        function checkFormInfo(form)
        {
            //
            // validate form fields
            //

            form.bttEnviarInfo.disabled = true;
            return true;
        }
        function checkFormPlace(form)
        {
            //
            // validate form fields
            //

            form.bttEnviarPlace.disabled = true;
            return true;
        }
        function checkFormProgram(form)
        {
            //
            // validate form fields
            //

            form.bttEnviarProgram.disabled = true;
            return true;
        }
        function checkFormRequiriment(form)
        {
            //
            // validate form fields
            //

            form.bttEnviarRequiriment.disabled = true;
            return true;
        }

        function limpiarCamposEspeciales() {



            var numPresidium = $('.clonedInput99').length;
            for (var i = 1; i <= numPresidium; i++) {
                if (i == 1) {

                } else {
                    $('#inputPresidium' + i).remove();
                    $("#btnAddPresidium").prop('disabled', false);
                }

            }
            $("#PresidiumNumero1").val("");
            $("#PresidiumNombre1").val("");
            $("#PresidiumCargo1").val("");
            $("#btnDelPresidium").prop('disabled', true);
            ////


            var numInvitadosE = $('.clonedInput2').length;
            for (var i = 1; i <= numInvitadosE; i++) {
                if (i == 1) {

                } else {
                    $('#inputInvitadosE' + i).remove();
                    $("#btnDelInvitadosE").prop('disabled', false);
                }

            }
            $("#InvitadosENumero1").val("");
            $("#InvitadosENombre1").val("");
            $("#InvitadosECargo1").val("");
            $("#btnDelInvitadosE").prop('disabled', true);
            /////

            var numOrdenDia = $('.clonedInput3').length;
            for (var i = 1; i <= numOrdenDia; i++) {
                if (i == 1) {

                } else {
                    $('#inputOrdenDia' + i).remove();
                    $("#btnDelOrdenDia").prop('disabled', false);
                }

            }
            $("#OrdenDiaNumero1").val("");
            $("#OrdenDiaIntervencion1").val("");
            $("#OrdenDiaCargo1").val("");
            $("#OrdenDiaDuracion1").val("");

            $("#btnDelOrdenDia").prop('disabled', true);

            /////
            var numPrimeraslineas = $('.clonedInput97').length;
            for (var i = 1; i <= numPrimeraslineas; i++) {
                if (i == 1) {

                } else {
                    $('#inputPrimeraslineas' + i).remove();
                    $("#btnAddPrimeraslineas").prop('disabled', false);
                }

            }
            $("#PrimeraslineasNumero1").val("");
            $("#PrimeraslineasNombre1").val("");
            $("#PrimeraslineasJustificacion1").val("");
            $("#btnDelPrimeraslineas").prop('disabled', true);
            //////
            var numMaterial = $('.clonedInput95').length;
            for (var i = 1; i <= numMaterial; i++) {
                if (i == 1) {

                } else {
                    $('#inputMateriales' + i).remove();
                    $("#btnAddMaterial").prop('disabled', false);
                }

            }
            $("#materialesNumero1").val("");
            $("#materialesMaterial1").val("0");
            $("#materialesObservacion1").val("");
            $("#btnDelMaterial").prop('disabled', true);
            /////////
            var numInsumo = $('.clonedInput94').length;
            for (var i = 1; i <= numInsumo; i++) {
                if (i == 1) {

                } else {
                    $('#inputInsumos' + i).remove();
                    $("#btnAddInsumo").prop('disabled', false);
                }

            }
            $("#insumosNumero1").val("");
            $("#insumosInsumo1").val("0");
            $("#insumosObservaciones1").val("");
            $("#btnDelInsumo").prop('disabled', true);
            /////////
            var numImagen = $('.clonedInput93').length;
            for (var i = 1; i <= numImagen; i++) {
                if (i == 1) {

                } else {
                    $('#inputImagen' + i).remove();
                    $("#btnAddImagen").prop('disabled', false);
                }

            }
            $("#imagenNumero1").val("");
            $("#imagenImagen1").val("0");
            $("#imagenObservaciones1").val("");
            $("#btnDelImagen").prop('disabled', true);
        }

        function aMays(e, elemento) {
            tecla = (document.all) ? e.keyCode : e.which;
            elemento.value = elemento.value.toUpperCase();
        }
        function justNumbers(e)
        {
            var keynum = window.event ? window.event.keyCode : e.which;
            if ((keynum == 8) || (keynum == 46))
                return true;

            return /\d/.test(String.fromCharCode(keynum));
        }

        function soloLetras(e) {
            key = e.keyCode || e.which;
            tecla = String.fromCharCode(key).toLowerCase();
            letras = " áéíóúabcdefghijklmnñopqrstuvwxyz";
            especiales = "8-37-39-46";

            tecla_especial = false
            for (var i in especiales) {
                if (key == especiales[i]) {
                    tecla_especial = true;
                    break;
                }
            }

            if (letras.indexOf(tecla) == -1 && !tecla_especial) {
                return false;
            }
        }

    </script>

</body>
</html>
