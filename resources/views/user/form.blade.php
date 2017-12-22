@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>User INDEx</h1>
@stop

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! Form::open(['url' => 'admin/user', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
    {{ Form::token() }}
    <div class="box-body">
        <input type="hidden" name="id" value="{{ isset($id) ? $id : old('id') }}">
        <div class="form-group">
            <label for="nama" class="col-md-4 control-label">Nama:</label>
            <div class="col-md-6">
                <input id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}" required autofocus>
                @if ($errors->has('name'))
                <span class="help-block">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-md-4 control-label">Email:</label>
            <div class="col-md-6">
                <input id="email" type="text" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}" required>
                @if ($errors->has('email'))
                <span class="help-block">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
            </div>
        </div>
        @if (!isset($id))
        <div class="form-group">
            <label for="password" class="col-md-4 control-label">Password:</label>
            <div class="col-md-6">
                <input id="password" type="password" class="form-control" name="password" value="{{ isset($password) ? $password : old('password') }}"  autofocus>
                @if ($errors->has('password'))
                <span class="help-block">
                    <strong>{{ $errors->first('password') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation" class="col-md-4 control-label">Ulangi Password:</label>
            <div class="col-md-6">
                <input id="password_confirmation" type="password" class="form-control" name="password_confirmation" value="{{ isset($password_confirmation) ? $password_confirmation : old('password_confirmation') }}"  autofocus>
                @if ($errors->has('password_confirmation'))
                <span class="help-block">
                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                </span>
                @endif
            </div>
        </div>
        @endif
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a class="btn btn-default" href="{{ route('permission.user.index') }}">
                Kembali
            </a>
    </div>
    
    {!! Form::close() !!}
</div>



@stop