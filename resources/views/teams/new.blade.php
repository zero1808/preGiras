@extends('layouts.app')

@section('content')
<div class="container">
    @if(Auth::user()->level == 1)

    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Registrar equipo</div>
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
                    <div class="form-group">
                        {!!Form::open(['route' => 'teams.store','method' => 'POST'])!!}
                        {{ csrf_field() }}

                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    {!! Form::label('nombre','Nombre de equipo: ')!!}
                                    {!! Form::text('nombre',null,['class' => 'form-control','required' => 'required','onkeyup'=>'aMays(event,this)'])!!}
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
                                            {!! Form::submit('Registrar',['class' => 'btn btn-success'])!!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {!!Form::close()!!}
                    </div>

                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
