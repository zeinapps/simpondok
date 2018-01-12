@extends('adminlte::page')

@section('title', 'Rombel '.$tahun->nama)

@section('content_header')
<h1>Rombel {{ $tahun->nama }}</h1>
@stop

@section('content')

<div class="box-body">
    {!! Form::open(['url' => 'admin/rombel', 'method' => 'POST','class'=>'form-horizontal' ]) !!}
    <div class="form-group">
        <label for="name" class="col-md-4 control-label">Tahun Ajaran:</label>
        <div class="col-md-6">
            {{ Form::select('tahun', $tahun_all, $tahun->id, ['onchange' => 'this.form.submit();' ,'class' => 'form-control select2 select2-hidden-accessible']) }}
        </div>
    </div>
    {!! Form::close() !!}
</div>
<div class="box">
    <div class="box-header">
        <h3 class="box-title">List Data</h3>

        <div class="box-tools">
            <form action="{{ route('permission.rombel.index',['tahun' => $tahun->id]) }}" method="GET">
                <div class="input-group input-group-sm" style="width: 450px;">
                    <input type="text" name="s" class="form-control pull-right" placeholder="Search" value="{{ isset($s) ? $s : old('s') }}">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                    {{ Form::select('tingkat_id', $tingkat ,  $tingkat_id , ['onchange' => 'this.form.submit();', 'class' => 'form-control pull-right']) }}
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default pull-right"
                                onclick="location.href ='{{ route('permission.rombel.add', ['tahun' => $tahun->id]) }}'">
                            <i class="fa fa-plus"></i>
                        </button>
                    </div>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-info pull-right"
                                onclick="location.href ='{{ route('permission.rombel.add', ['tahun' => $tahun->id]) }}'">
                            Gunakan Data Default
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="box-body table-responsive no-padding">
        <table class="table table-hover">
            <tbody>
                <tr>
                    <th>Tingkat</th>
                    <th>Nama</th>
                    <th>Daya Tampung</th>
                    <th>Wali</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
                @foreach ($data as $v)
                <tr>
                    <td>
                        {{ $v->tingkat }}
                    </td>
                    <td>
                        {{ $v->nama }}
                    </td>
                    <td>
                        {{ $v->max_siswa }}
                    </td>
                    <td>
                        {{ $v->wali->name }}
                    </td>
                    <td>
                        {{ $v->keterangan }}
                    </td>
                    <td>
                        <a class="btn btn-warning btn-xs" href="{{ route('permission.rombel.edit',['tahun' => $tahun->id, 'id' => $v->id ]) }}" style="float: left; margin-right: 5px;">Edit</a>
                       
                    </td>

                </tr>
                @endforeach
            </tbody></table>
            
    </div>
    <div class="box-footer">
        {{ $data->links() }}
    </div>
    <!-- /.box-body -->
</div>

@stop