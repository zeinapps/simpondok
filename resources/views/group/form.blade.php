

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
    {!! Form::open(['url' => 'admin/group', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
    {{ Form::token() }}
    <div class="box-body">
        <input type="hidden" name="id" value="{{ isset($id) ? $id : old('id') }}">
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Nama:</label>
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
            <label for="display_name" class="col-md-4 control-label">Display:</label>
            <div class="col-md-6">
                <input id="display_name" type="text" class="form-control" name="display_name" value="{{ isset($display_name) ? $display_name : old('display_name') }}" required>
                @if ($errors->has('display_name'))
                <span class="help-block">
                    <strong>{{ $errors->first('display_name') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="description" class="col-md-4 control-label">Description:</label>
            <div class="col-md-6">
                <input id="description" type="text" class="form-control" name="description" value="{{ isset($description) ? $description : old('description') }}" required>
                @if ($errors->has('description'))
                <span class="help-block">
                    <strong>{{ $errors->first('description') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a class="btn btn-default" href="{{ route('permission.group.index') }}">
                Kembali
            </a>
    </div>
    
    {!! Form::close() !!}
</div>



@stop