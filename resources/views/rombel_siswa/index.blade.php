@extends('adminlte::page')

@section('title', 'Rombel Siswa')

@section('content_header')
<h1>Rombel Siswa {{ $tahun->nama }}</h1>
@stop
@section('content')
{!! Form::open(['url' => 'admin/rombel_siswa', 'method' => 'POST','class'=>'form-horizontal' ]) !!}
    
<div class="box-body">
    {!! Form::open(['url' => 'admin/rombel_siswa', 'method' => 'POST','class'=>'form-horizontal' ]) !!}
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Tahun Ajaran:</label>
        <div class="col-md-6">
            {{ Form::select('tahun', $tahun_all, $tahun->id, ['onchange' => 'this.form.submit();' ,'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="row">
    {!! Form::open(['url' => route('permission.rombel_siswa.index',['tahun' => $tahun->id]), 'method' => 'GET' ]) !!}
    <div class="col-md-6">
        <div class="form-group">
            <label>Pilih Tingkat</label>
            {{ Form::select('tingkat_id', $tingkat ,  $tingkat_id , ['onchange' => 'this.form.submit();', 'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group">
            <label>Pilih Rombel</label>
            {{ Form::select('rombel_id', $rombel ,  $rombel_id , ['onchange' => 'this.form.submit();', 'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="row">
    
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Belum di masukkan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['url' => route('permission.rombel_siswa.index',['tahun' => $tahun->id]), 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
            {{ Form::token() }}
            <input type="hidden" name="rombel_id" value="{{ $rombel_id }}">
                <table class="table table-condensed">
                    <tbody>
                    <tr >
                        <th style="width: 10px">No</th>
                        <th style="width: 100px">Pilih Induk</th>
                        <th>Nama</th>
                    </tr>
                    <?php $nomer_urut = 1; ?>
                        @foreach ($siswa as $m)
                            <tr>
                                <td>
                                    <label>   
                                        {{ $nomer_urut++ }}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{ Form::checkbox('siswa[]', $m->id, false) }}
                                        {{$m->nomor_induk}}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{$m->nama}}  
                                    </label>
                                </td>
                            </tr>
                     
                        @endforeach
                        
                    </tbody>
                </table>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary">>>>></button>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box -->


    </div>
    <div class="col-md-6">
        <!-- general form elements -->
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Sudah di masukkan</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            {!! Form::open(['url' => route('permission.rombel_siswa.index',['tahun' => $tahun->id]), 'method' => 'DELETE','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
            {{ Form::token() }}
            <input type="hidden" name="rombel_id" value="{{ $rombel_id }}">
                <table class="table table-condensed">
                    <tbody>
                        <tr >
                            <th style="width: 10px">No</th>
                            <th style="width: 100px">Pilih Induk</th>
                            <th>Nama</th>
                        </tr>
                        <?php $nomer_urut = 1; ?>
                        @foreach ($rombel_siswa as $m)
                            <tr>
                                <td>
                                    <label>   
                                        {{ $nomer_urut++ }}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{ Form::checkbox('siswa[]', $m->id, false) }}
                                        {{$m->nomor_induk}}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{$m->nama}}  
                                    </label>
                                </td>
                            </tr>
                        @endforeach
                        
                    </tbody>
                </table>
                <div class="box-footer">
                    <button type="submit" class="btn btn-primary"><<<<</button>
                    <a type="submit" href="{{route('permission.rombel_siswa.export_presensi',['tahun' => $tahun->id, 'rombel_id' => $rombel_id])}} "class="btn btn-primary">Export Presensi</a>
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box -->


    </div>
</div>
@stop
