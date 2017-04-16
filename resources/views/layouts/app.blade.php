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
        {{Html::style('css/font-awesome.min.css')}}
        {{Html::style('css/dataTables.bootstrap.min.css')}}
        {{Html::style('css/buttons.bootstrap.min.css')}}
        {{Html::style('css/fixedHeader.bootstrap.min.css')}}  

        <!-- Scripts -->
        <script>
            window.Laravel = {!! json_encode([
                    'csrfToken' => csrf_token(),
            ]) !!}
            ;
        </script>
    </head>
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

            @yield('content')
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        {{Html::script('js/validaciones.js')}}
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
    </body>
</html>
