@extends('layouts.app')
@section('content')

<div class="container">
     @if (isset($errors) && $errors->has(''))
                                <div class="alert alert-danger">
                                    @foreach ($errors->all() as $error)
                                    <strong>{{$error}}</strong>
                                    @endforeach
                                </div>   
                                @endif
    <div class="col-md-10 col-md-offset-1">
        <div class="alert alert-danger">
            <strong>Parece que aun no tienes un perfil, a continuaci&oacute;n crearemos uno</strong>
        </div>  
        <div class="panel panel-default">
            <div class="panel-heading">Creaci&oacute;n de perfil</div>
            <div class="panel-body">
                <div class="form-group">  
                    {!! Form::open(['route' => 'profiles.store', 'method'=>'POST']) !!}
                    {{ csrf_field() }}

                    <div class="row">
                        <div class="col-sm-12">

                            {!! Form::label('name','Nombre(s): ')!!}
                            {!! Form::text('name',null,['class' => 'form-control','required'=>'required','onkeypress'=>'return soloLetras(event);','onkeyup'=>' aMays(event,this);'])!!}
                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('ap_paterno',"Apellido paterno:")!!}
                            {!! Form::text('ap_paterno',null,['class' => 'form-control','required'=>'required','onkeypress'=>'return soloLetras(event);','onkeyup'=>' aMays(event,this);'])!!}
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('ap_materno',"Apellido materno:")!!}
                            {!! Form::text('ap_materno',null,['class' => 'form-control','required'=>'required','onkeypress'=>'return soloLetras(event);','onkeyup'=>'aMays(event,this);'])!!}

                        </div>

                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            {!! Form::label('direccion',"Ingrese su calle y numero:")!!}
                            {!! Form::text('direccion',null,['class' => 'form-control','required'=>'required','onkeyup'=>'aMays(event,this);'])!!}
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <label for="municipio">Municipio:</label>
                            <select id="municipio" name="municipio" class="form-control" required="true">
                                @foreach ($municipios as $municipio)
                                <option value="{{ $municipio->id }}">{{ $municipio->name }}</option>
                                @endforeach             
                            </select>

                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            {!! Form::label('telefono_cel','Teléfono celular: ')!!}
                            <input type="text" id="telefono_cel" name="telefono_cel" class="form-control" maxlength="10" minlength="10" onkeypress="return justNumbers(event);" required="true">  
                        </div>
                        <div class="col-sm-6">
                            {!! Form::label('telefono_casa','Teléfono casa: ')!!}
                            <input type="text" id="telefono_casa" name="telefono_casa" class="form-control" maxlength="10" minlength="10" onkeypress="return justNumbers(event);">  
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-sm-6">  
                            {!! Form::submit('Registrar',['class' => 'btn btn-success'])!!}
                        </div>     
                    </div>
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>

       

@endsection