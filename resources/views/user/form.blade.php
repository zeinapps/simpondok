@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1>User</h1>
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
        <div class="form-group">
            <label for="email" class="col-md-4 control-label">Role:</label>
            <div class="col-md-6">
                @foreach ($roles as $r)
                
                <label>   {{ Form::checkbox('roles[]', $r->id, isset($r->cheked)?$r->cheked:false, ['class' => 'minimal']) }}
                   {{$r->display_name}} 
                </label>
                <br>
                     
                @endforeach
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
        <div class="form-group">
            <label for="telp" class="col-md-4 control-label">Telp:</label>
            <div class="col-md-6">
                <input id="telp" type="text" class="form-control" name="telp" value="{{ isset($telp) ? $telp : old('telp') }}">
                @if ($errors->has('telp'))
                <span class="help-block">
                    <strong>{{ $errors->first('telp') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="alamat" class="col-md-4 control-label">Alamat:</label>
            <div class="col-md-6">
                <input id="alamat" type="text" class="form-control" name="alamat" value="{{ isset($alamat) ? $alamat : old('alamat') }}">
                @if ($errors->has('alamat'))
                <span class="help-block">
                    <strong>{{ $errors->first('alamat') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="tempat_lahir" class="col-md-4 control-label">Tempat Lahir:</label>
            <div class="col-md-6">
                <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ isset($tempat_lahir) ? $tempat_lahir : old('tempat_lahir') }}">
                @if ($errors->has('tempat_lahir'))
                <span class="help-block">
                    <strong>{{ $errors->first('tempat_lahir') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="form-group">
            <label for="name" class="col-md-4 control-label">Tanggal Lahir:</label>
            <div class="col-md-6">
                <input type="text" name="tanggal_lahir" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" value="{{ isset($tanggal_lahir) ? $tanggal_lahir : old('tanggal_lahir') }}" data-mask="">
            </div>
        </div>
        <div class="form-group">
            <label for="tahun_masuk" class="col-md-4 control-label">Tahun Masuk:</label>
            <div class="col-md-6">
                <input id="datemask2" type="text" class="form-control" name="tahun_masuk" data-inputmask="'alias': 'y'" value="{{ isset($tahun_masuk) ? $tahun_masuk : old('tahun_masuk') }}" data-mask="">
                
            </div>
        </div>
        
        <div class="form-group">
            <label for="riwayat_pelatihan" class="col-md-4 control-label">Riwayat Pelatihan:</label>
            <div class="col-md-6">
                <textarea id="riwayat_pelatihan" class="form-control" name="riwayat_pelatihan" >{{ isset($riwayat_pelatihan) ? $riwayat_pelatihan : old('riwayat_pelatihan') }}</textarea>
               
            </div>
        </div>
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
@section('js')
<script src="{{ asset('vendor/adminlte/plugins/input-mask/jquery.inputmask.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
<script src="{{ asset('vendor/adminlte/plugins/input-mask/jquery.inputmask.extensions.js') }}"></script>
<script>
  $(function () {
    
    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
//    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('y', { 'placeholder': 'y' })
//    //Money Euro
    $('[data-mask]').inputmask()
  })
</script>
@stop