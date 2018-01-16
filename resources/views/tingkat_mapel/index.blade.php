@extends('adminlte::page')

@section('title', 'Tingkat Mapel '.$tahun->nama )

@section('content_header')
<h1>Tingkat Mapel {{ $tahun->nama }}</h1>
@stop
@section('content')
<div class="box-body">
    {!! Form::open(['url' => 'admin/tingkat_mapel', 'method' => 'POST','class'=>'form-horizontal' ]) !!}
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Tahun Ajaran:</label>
        <div class="col-md-6">
            {{ Form::select('tahun', $tahun_all, $tahun->id, ['onchange' => 'this.form.submit();' ,'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="row">
    <div class="col-md-6">
    {!! Form::open(['url' => route('permission.tingkat_mapel.index',['tahun' => $tahun->id]), 'method' => 'GET' ]) !!}

        <div class="form-group">
            <label>Pilih Tingkat</label>
            {{ Form::select('tingkat_id', $tingkat ,  $tingkat_id , ['onchange' => 'this.form.submit();', 'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>

    {!! Form::close() !!}
    </div>
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
            {!! Form::open(['url' => route('permission.tingkat_mapel.index',['tahun' => $tahun->id]), 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
            {{ Form::token() }}
            <input type="hidden" name="tingkat_id" value="{{ $tingkat_id }}">
                <table class="table table-condensed">
                    <tbody>
                        <tr >
                            <th style="width: 10px">No</th>
                            <th style="width: 100px">Pilih Kode</th>
                            <th>Nama</th>
                        </tr>
                        <?php $nomer_urut = 1; ?>
                        @foreach ($mapel as $m)
                            <tr>
                                <td>
                                    <label>   
                                        {{ $nomer_urut++ }}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{ Form::checkbox('mapel[]', $m->id, false) }}
                                        {{$m->kode}}
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
            {!! Form::open(['url' => route('permission.tingkat_mapel.index',['tahun' => $tahun->id]), 'method' => 'DELETE','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
            {{ Form::token() }}
            <input type="hidden" name="tingkat_id" value="{{ $tingkat_id }}">
                <table class="table table-condensed">
                    <tbody>
                        <tr >
                            <th style="width: 10px">No</th>
                            <th style="width: 100px">Pilih Kode</th>
                            <th>Nama</th>
                        </tr>
                        <?php $nomer_urut = 1; ?>
                        @foreach ($mapel_tingkat as $m)
                            <tr>
                                <td>
                                    <label>   
                                        {{ $nomer_urut++ }}
                                    </label>
                                </td>
                                <td>
                                    <label>   
                                        {{ Form::checkbox('mapel[]', $m->id, false) }}
                                        {{$m->kode}}
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
                </div>
            {!! Form::close() !!}
        </div>
        <!-- /.box -->


    </div>
</div>
@stop
