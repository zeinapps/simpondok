@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Siswa</h1>
@stop

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">List Data</h3>

    </div>
    {!! Form::open(['url' => 'admin/siswa/storeupload', 'method' => 'POST' ])!!}
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>Nama</th>
                    <th>No Induk</th>
                    <th>Alamat</th>
                    <th>Tempat Lahir</th>
                    <th>Tanggal Lahir</th>
                    <th>Keterangan</th>
                </tr>
                
                @foreach ($data as $v)
                <tr class="{{ $v['class'] }}">
                    <td>
                        {{ $v['nama'] }}
                        <input type="hidden" name="nama[]" value="{{ $v['nama'] }}" />
                    </td>
                    <td>
                        {{ $v['nomor_induk'] }}
                        <input type="hidden" name="nomor_induk[]" value="{{ $v['nomor_induk'] }}" />
                    </td>
                    <td>
                        {{ $v['alamat'] }}
                        <input type="hidden" name="alamat[]" value="{{ $v['alamat'] }}" />
                    </td>
                    <td>
                        {{ $v['tempat_lahir'] }}
                        <input type="hidden" name="tempat_lahir[]" value="{{ $v['tempat_lahir'] }}" />
                    </td>
                    <td>
                        {{ $v['tanggal_lahir'] }}
                        <input type="hidden" name="tanggal_lahir[]" value="{{ $v['tempat_lahir'] }}" />
                    </td>
                    <td>
                        {{ $v['message'] }}
                    </td>

                </tr>
                @endforeach
            </tbody></table>
            
    </div>
    <div class="box-footer">
         @if ($is_submit)
            <button type="submit" class="btn btn-primary">
                Upload
            </button>
        @endif
        
        <a class="btn btn-default" href="{{ route('permission.siswa.formupload') }}">
            Kembali
        </a>
    </div>
    {!! Form::close() !!}
    <!-- /.box-body -->
</div>

@stop