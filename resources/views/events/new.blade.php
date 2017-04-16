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
        {{Html::style('clockpicker/dist/bootstrap-clockpicker.min.css')}}

        <!-- Scripts -->
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
        #floating-panel {
            position: absolute;
            top: 10px;
            left: 25%;
            z-index: 5;
            background-color: #fff;
            padding: 5px;
            border: 1px solid #999;
            text-align: center;
            font-family: 'Roboto','sans-serif';
            line-height: 30px;
            padding-left: 10px;
        }
        .popover {
            z-index: 215000000 !important;
        }
    </style>
    <body>
        <div id="app">
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
                @if(Auth::user()->level == 1)

                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="panel panel-default">
                            <div class="panel-heading">C&eacute;dula de informaci&oacute;n b&aacute;sica</div>
                            @if(isset($messages))
                            <div class="alert alert-success">
                                <strong>{{$messages}}</strong>
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
                                <center><h2>Informaci&oacute;n general del evento</h2></center>

                                <hr>
                                <div class="form-group">
                                    {!!Form::open(['route' => 'events.store','method' => 'POST','files'=>true,'onsubmit'=>'return checkForm(this);'])!!}
                                    {{ csrf_field() }}

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
                                                <input id="fi" class="date-picker form-control calendario" required="required" type="text" name="fi" onkeypress="return justNumbers(event);" readonly="true">                                            </div>
                                        </div> 

                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="hi">Hora de inicio del evento:</label>
                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                                    <input type="text" id="hi" name="hi" class="form-control" value="09:30" onkeypress="return justNumbers(event);" readonly="true"> 
                                                    <span class="input-group-addon" id="hi" name="hi">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="hi">Hora de conclusi&oacute;n del evento:</label>
                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                                    <input type="text" id="hf" name="hf" class="form-control" value="10:30" onkeypress="return justNumbers(event);" readonly="true">
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
                                                    <input type="text" id="h_arribo" name="h_arribo" class="form-control" value="10:30" onkeypress="return justNumbers(event);" readonly="true">
                                                    <span class="input-group-addon" id="h_arribo" name="h_arribo">
                                                        <span class="fa fa-clock-o"></span>
                                                    </span>
                                                </div>                                            </div>
                                        </div>   
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="hi">Hora de convocatoria:</label>
                                                <div class="input-group clockpicker" data-placement="left" data-align="top" data-autoclose="true">                                                 
                                                    <input type="text" id="h_convocatoria" name="h_convocatoria" class="form-control" value="09:30" onkeypress="return justNumbers(event);" readonly="true" >
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
                                                {!! Form::text('calle_numero',null,['class' => 'form-control','required' => 'required' ,'onkeyup'=>'aMays(event,this)'])!!}
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
                                                <label for="seccion_impactada">Secci&oacute;nal impactada:</label>
                                                <select id="seccion_impactada" name="seccion_impactada" class="form-control" required="true">

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="distrito">Distrito impactado:</label>
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
                                                <textarea id="objetivo" class="form-control" name="objetivo" required rows="6"  onkeyup="aMays(event, this)">
                                                </textarea>
                                            </div>
                                        </div> 

                                    </div>
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
                                    <div class="row">
                                        <div class="col-sm-6">
                                        </div>
                                        <div class="col-sm-6">
                                            <div clas="row">
                                                <div class="col-sm-6">
                                                </div>
                                                <div class="col-sm-6">
                                                    <div align="right">
                                                        {!! Form::submit('Registrar',['class' => 'btn btn-success','name'=>'bttEnviar'])!!}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {!!Form::close()!!}
                                    <button id="btt-seach" name="btt-search" class="btn btn-primary" onclick="codeAddress()">Buscar direcci&oacute;n escrita arriba</button>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                @endif
            </div>


        </div>
        <div class="modal fade" id="progressDialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <p>Please wait while we update your topic. You will be redirected automatically!</p>

                        <div class="progress progress-striped active">
                            <div class="progress-bar"  role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
                                <span class="sr-only">/span>
                            </div>
                        </div>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        {{Html::script('js/jquery.js')}}
        {{Html::script('js/jquery.min.js')}}
        {{Html::script('js/icheck.min.js')}}
        {{Html::script('js/moment.min.js')}}
        {{Html::script('js/daterangepicker.js')}}
        {{Html::script('js/jquery.hotkeys.js')}}
        {{Html::script('js/switchery.min.js')}}
        {{Html::script('clockpicker/dist/bootstrap-clockpicker.min.js')}}
        {{Html::script('js/validaciones.js')}}
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDe1EXskkLEuvjNT20NBVcpH9BFTxEdpj4"
        async defer></script>


        <script>var path = "{{URL::to('/')}}"</script>

        <script>
            var map;
            var markers = [];
            var haightAshbury = {lat: 19, lng: -98.8167};
            $(document).ready(function () {
                localizame();
                //calendarios
                $('.calendario').daterangepicker({
                    singleDatePicker: true,
                    calender_style: "picker_4"
                }, function (start, end, label) {
                    console.log(start.toISOString(), end.toISOString(), label);
                });

                $('#municipio').change(function () {
                    if ($('#municipio').val() != 0) {
                        searchSeccionalByMunicipio();
                    } else {

                    }
                });
                $("#municipio").trigger('change');


            });


            function localizame() {
                if (navigator.geolocation) { /* Si el navegador tiene geolocalizacion */
                    navigator.geolocation.getCurrentPosition(coordenadas, errores);
                } else {
                    alert("Denegaste acceder a tu ubicación");
                    cargarMapaSinLoc();
                }
            }

            function coordenadas(position) {
                $("#lat").val(position.coords.latitude); /*Guardamos nuestra latitud*/
                $("#lng").val(position.coords.longitude); /*Guardamos nuestra longitud*/
                cargarMapa();
            }

            function errores(err) {
                /*Controlamos los posibles errores */
                if (err.code == 0) {
                    alert("Oops! Algo ha salido mal");
                }
                if (err.code == 1) {
                    alert("Oops! No has aceptado compartir tu posición");
                    cargarMapaSinLoc();
                }
                if (err.code == 2) {
                    alert("Oops! No se puede obtener la posición actual");
                }
                if (err.code == 3) {
                    alert("Oops! Hemos superado el tiempo de espera");
                }
            }

            function cargarMapa() {

                var location = {lat: parseFloat($("#lat").val()), lng: parseFloat($("#lng").val())};
                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 17,
                    center: location,
                    mapTypeId: google.maps.MapTypeId.TERRAIN
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
            function cargarMapaSinLoc() {

                map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 17,
                    center: haightAshbury,
                    mapTypeId: google.maps.MapTypeId.TERRAIN
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
                addMarker(haightAshbury);
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
        </script>
        <script type="text/javascript">
            let options =
                    {
                        donetext: 'Done',
                        placement: 'bottom',
                        align: 'left'
                    }
            $('.clockpicker').clockpicker(options);
            function checkForm(form)
            {
                //
                // validate form fields
                //

                form.bttEnviar.disabled = true;
                return true;
            }

        </script>
    </body>
</html>
