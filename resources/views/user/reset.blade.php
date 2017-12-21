@extends('layouts.app')
@section('content')
<div class="row">

    <div class="panel panel-default">
        <div class="panel-heading">Form</div>

        <div class="panel-body">
            @include('default.notifikasi.error')
            @include('default.notifikasi.success')
            {!! Form::open(['url' => 'reset', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
            {{ Form::token() }}
            <input type="hidden" name="id" value="{{ isset($id) ? $id : old('id') }}">
            <div class="form-group">
                <label for="nama" class="col-md-4 control-label">Nama:</label>
                <div class="col-md-6">
                    <input readonly="" id="name" type="text" class="form-control" name="name" value="{{ isset($name) ? $name : old('name') }}" required autofocus>
                    
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-md-4 control-label">Password Baru:</label>
                <div class="col-md-6">
                    <input id="password" type="text" class="form-control" name="password" value="{{ isset($password) ? $password : old('password') }}" required autofocus>
                    @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
            </div>
            <div class="form-group">
                <div class="col-md-8 col-md-offset-4">
                    <button type="submit" class="btn btn-primary">
                        Simpan
                    </button>
                    <a class="btn btn-default" href="{{ url('/user') }}">
                        Kembali
                    </a>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </div>
</div>
<script>
    document.getElementById("gambar").onchange = function () {
        document.getElementById("gambar2").value = this.value;
    };
</script>

@endsection