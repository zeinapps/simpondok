

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Rombel</h1>
@stop

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div>
    <!-- /.box-header -->
    <!-- form start -->
    
    
<div class="box-body">
    {!! Form::open(['url' => 'admin/rombel', 'method' => 'POST','class'=>'form-horizontal' ]) !!}
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Tahun Ajaran:</label>
        <div class="col-md-6">
            {{ Form::select('tahun', $tahun, null, ['onchange' => 'this.form.submit();' ,'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    {!! Form::close() !!}
</div>



@stop