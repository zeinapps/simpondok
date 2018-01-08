

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>Siswa</h1>
@stop

@section('content')

<div class="box box-info">
    <div class="box-header with-border">
        <h3 class="box-title">Form Data Siswa</h3>
    </div>
    <!-- /.box-header -->
    <div class="row">
        <div class="input-group-btn" style="text-align: center">
            <button type="button" class="btn btn-info"
                    onclick="location.href ='/excel/format_upload.xlsx'">
                Undah Format
            </button>
        </div>
    </div>
    <!-- form start -->
    {!! Form::open(['url' => 'admin/siswa/uploadexcel', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
    {{ Form::token() }}
    <div class="box-body">
        <input type="hidden" name="id" value="{{ isset($id) ? $id : old('id') }}">
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Nama:</label>
            <div class="col-md-6 input-group">
                <input type="text" id="file_path" class="form-control" placeholder="Browse...">
                <span class="input-group-btn">
                    <button class="btn btn-default" type="button" id="file_browser">
                    <i class="fa fa-search"></i> Browse</button>
                </span>
                <input type="file" class="hidden" id="file" name="file">
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
                Upload
            </button>
            <a class="btn btn-default" href="{{ route('permission.siswa.index') }}">
                Kembali
            </a>
    </div>
    
    {!! Form::close() !!}
</div>



@stop
@section('js')
<script>
  $(function () {
    $('#file_browser').click(function(e){
    e.preventDefault();
    $('#file').click();
});

$('#file').change(function(){
    $('#file_path').val($(this).val());
});

$('#file_path').click(function(){
    $('#file_browser').click();
});
  })
</script>
@stop