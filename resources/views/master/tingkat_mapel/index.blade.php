@extends('adminlte::page')

@section('title', 'Master Tingkat Mapel')

@section('content_header')
<h1>Master Tingkat Mapel</h1>
@stop
@section('content')

<div class="row">
    <div class="col-md-6">
    {!! Form::open(['url' => 'admin/m_tingkat_mapel', 'method' => 'GET' ]) !!}

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
            {!! Form::open(['url' => 'admin/m_tingkat_mapel', 'method' => 'POST','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
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
            {!! Form::open(['url' => 'admin/m_tingkat_mapel', 'method' => 'DELETE','class'=>'form-horizontal' , 'enctype'=>'multipart/form-data']) !!}
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
