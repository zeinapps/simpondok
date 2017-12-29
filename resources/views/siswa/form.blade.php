

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
    <!-- form start -->
    {!! Form::open(['url' => 'admin/siswa', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
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
            <label for="nomor_induk" class="col-md-4 control-label">No Induk:</label>
            <div class="col-md-6">
                <input id="nomor_induk" type="text" class="form-control" name="nomor_induk" value="{{ isset($nomor_induk) ? $nomor_induk : old('nomor_induk') }}" >
                @if ($errors->has('nomor_induk'))
                <span class="help-block">
                    <strong>{{ $errors->first('nomor_induk') }}</strong>
                </span>
                @endif
            </div>
        </div>
    </div>
    <div class="">
        <div class="box box-solid">
            <div class="box-group" id="accordion">
                <!-- we are adding the .panel class so bootstrap.js collapse plugin detects it -->
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" class="collapsed">
                                Keterangan siswa
                            </a>
                        </h4>
                    </div>
                    <div id="collapseOne" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Tempat Lahir:</label>
                                <div class="col-md-6">
                                    <input id="tempat_lahir" type="text" class="form-control" name="tempat_lahir" value="{{ isset($tempat_lahir) ? $tempat_lahir : old('tempat_lahir') }}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Tanggal Lahir:</label>
                                <div class="col-md-6">
                                    <input type="text" name="tanggal_lahir" class="form-control" data-inputmask="'alias': 'yyyy-mm-dd'" value="{{ isset($tanggal_lahir) ? $tanggal_lahir : old('tanggal_lahir') }}" data-mask="">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Jenis Kelamin:</label>
                                <div class="col-md-6">
                                {{ Form::select('kelamin', config('form.kelamin'),  isset($kelamin) ? $kelamin : old('kelamin'), ['class' => 'form-control select2 select2-hidden-accessible']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Agama:</label>
                                <div class="col-md-6">
                                {{ Form::select('agama', config('form.agama'),  isset($agama) ? $agama : old('agama'), ['class' => 'form-control select2 select2-hidden-accessible']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kewarganegaraan:</label>
                                <div class="col-md-6">
                                    <input type="text" name="kewarganegaraan" class="form-control" value="{{ isset($kewarganegaraan) ? $kewarganegaraan : old('kewarganegaraan') }}">
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Jumlah Saudara:</label>
                                <div class="col-md-6">
                                    Kandung<input type="number" min="0" name="jml_saudara_kandung" class="form-control"  value="{{ isset($jml_saudara_kandung) ? $jml_saudara_kandung : old('jml_saudara_kandung') }}" >
                                    Tiri<input type="number" min="0" name="jml_saudara_tiri" class="form-control"  value="{{ isset($jml_saudara_tiri) ? $jml_saudara_tiri : old('jml_saudara_tiri') }}" >
                                    Angkat<input type="number" min="0" name="jml_saudara_angkat" class="form-control"  value="{{ isset($jml_saudara_angkat) ? $jml_saudara_angkat : old('jml_saudara_angkat') }}" >

                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Yatim:</label>
                                <div class="col-md-6">
                                {{ Form::select('yatim', config('form.yatim'),  isset($yatim) ? $yatim : old('yatim'), ['class' => 'form-control select2 select2-hidden-accessible']) }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Bahasa Sehari-hari:</label>
                                <div class="col-md-6">
                                    <input type="text" name="bahasa" class="form-control" value="{{ isset($bahasa) ? $bahasa : old('bahasa') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse2" aria-expanded="false" class="collapsed">
                                Keterangan Tempat Tinggal
                            </a>
                        </h4>
                    </div>
                    <div id="collapse2" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Alamat:</label>
                                <div class="col-md-6">
                                    <input id="alamat" type="text" class="form-control" name="alamat" value="{{ isset($alamat) ? $alamat : old('alamat') }}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kelurahan/Desa:</label>
                                <div class="col-md-6">
                                    <input id="alamat" type="text" class="form-control" name="kelurahan" value="{{ isset($kelurahan) ? $kelurahan : old('kelurahan') }}" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kecamatan:</label>
                                <div class="col-md-6">
                                    <input  name="kecamatan" value="{{ isset($kecamatan) ? $kecamatan : old('kecamatan') }}" id="kecamatan" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kota/Kabupaten:</label>
                                <div class="col-md-6">
                                    <input  name="kota" value="{{ isset($kota) ? $kota : old('kota') }}" id="kota" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Kode Pos:</label>
                                <div class="col-md-6">
                                    <input  name="kode_pos" value="{{ isset($kode_pos) ? $kode_pos : old('kode_pos') }}" id="kode_pos" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Telp/HP:</label>
                                <div class="col-md-6">
                                    <input  name="telp" value="{{ isset($telp) ? $telp : old('telp') }}" id="telp" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Tinggal Dengan:</label>
                                <div class="col-md-6">
                                    <input  name="tinggal_dengan" value="{{ isset($tinggal_dengan) ? $tinggal_dengan : old('tinggal_dengan') }}" id="tinggal_dengan" type="text" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name" class="col-md-4 control-label">Jarak Sekolah(KM):</label>
                                <div class="col-md-6">
                                    <input  name="jarak_sekolah" value="{{ isset($jarak_sekolah) ? $jarak_sekolah : old('jarak_sekolah') }}" id="jarak_sekolah" type="number" min="0" class="form-control" >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse3" aria-expanded="false" class="collapsed">
                                Keterangan Kesehatan
                            </a>
                        </h4>
                    </div>
                    <div id="collapse3" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse4" aria-expanded="false" class="collapsed">
                                Keterangan Pendidikan Sebelumnya
                            </a>
                        </h4>
                    </div>
                    <div id="collapse4" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse5" aria-expanded="false" class="collapsed">
                                Keterangan Pendidikan Mutasi Masuk
                            </a>
                        </h4>
                    </div>
                    <div id="collapse5" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse6" aria-expanded="false" class="collapsed">
                                Keterangan Pendidikan Sekollah Ini
                            </a>
                        </h4>
                    </div>
                    <div id="collapse6" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse7" aria-expanded="false" class="collapsed">
                                Keterangan Ayah Kadung
                            </a>
                        </h4>
                    </div>
                    <div id="collapse7" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse8" aria-expanded="false" class="collapsed">
                                Keterangan Ibu Kadung
                            </a>
                        </h4>
                    </div>
                    <div id="collapse8" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse9" aria-expanded="false" class="collapsed">
                                Keterangan Wali
                            </a>
                        </h4>
                    </div>
                    <div id="collapse9" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse10" aria-expanded="false" class="collapsed">
                                Kegemaran Siswa
                            </a>
                        </h4>
                    </div>
                    <div id="collapse10" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse11" aria-expanded="false" class="collapsed">
                                Perkembangan Siswa
                            </a>
                        </h4>
                    </div>
                    <div id="collapse11" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse12" aria-expanded="false" class="collapsed">
                                Keterangan Lulus
                            </a>
                        </h4>
                    </div>
                    <div id="collapse12" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
                <div class="panel box box-primary">
                    <div class="box-header with-border">
                        <h4 class="box-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapse13" aria-expanded="false" class="collapsed">
                                Lain - Lain
                            </a>
                        </h4>
                    </div>
                    <div id="collapse13" class="panel-collapse collapse" aria-expanded="false" style="height: 0px;">
                        <div class="box-body">
                            
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
    <div class="box-footer">
        <button type="submit" class="btn btn-primary">
                Simpan
            </button>
            <a class="btn btn-default" href="{{ route('permission.siswa.index') }}">
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
//    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
//    //Money Euro
    $('[data-mask]').inputmask()
  })
</script>
@stop