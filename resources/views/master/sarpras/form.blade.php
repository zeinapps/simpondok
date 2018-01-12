

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Master Sarpras</h1>
@stop

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    {!! Form::open(['url' => 'admin/sarpras', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
    {{ Form::token() }}
    <div class="box-body">
        <input type="hidden" name="id" value="{{ isset($id) ? $id : old('id') }}">
        
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Nama:</label>
            <div class="col-md-6">
                <input id="nama" type="text" class="form-control" name="nama" value="{{ isset($nama) ? $nama : old('nama') }}" required autofocus>
                @if ($errors->has('nama'))
                <span class="help-block">
                    <strong>{{ $errors->first('nama') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Keterangan:</label>
            <div class="col-md-6">
                <input id="keterangan" type="text" class="form-control" name="keterangan" value="{{ isset($keterangan) ? $keterangan : old('keterangan') }}" autofocus>
                @if ($errors->has('keterangan'))
                <span class="help-block">
                    <strong>{{ $errors->first('keterangan') }}</strong>
                </span>
                @endif
            </div>
        </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a class="btn btn-default" href="{{ route('permission.sarpras.index') }}">
                Kembali
            </a>
    </div>
    
    {!! Form::close() !!}
</div>



@stop