@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registro</div>
                @if(isset($messages))
                <div class="alert alert-success">
                    <strong>{{$messages}}</strong>
                </div>   
                <br>
                @endif
                <div class="panel-body">
                    @if(Auth::user()->level == 1 || Auth::user()->level == 2 || Auth::user()->level == 3)
                    <div clas="row">
                    <div class="col-sm-12">
                    <iframe src="https://calendar.google.com/calendar/embed?title=Giras%20y%20Log%C3%ADstica&amp;showCalendars=0&amp;height=600&amp;wkst=1&amp;hl=es_419&amp;bgcolor=%23ffffff&amp;src=gyladm2017%40gmail.com&amp;color=%231B887A&amp;ctz=America%2FMexico_City" style="border-width:0" width="100%" height="450" frameborder="0" scrolling="no"></iframe>
                    </div>
                    </div>
                    @else
                    <center><h1>No tienes permiso de estar aqui</h1></center>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
