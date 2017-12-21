@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>User INDEx</h1>
@stop

@section('content')

<div class="box">
    <div class="box-header">
        <h3 class="box-title">List Data</h3>

        <div class="box-tools">
            <form action="{{ route('permission.user.index') }}" method="GET">
                <div class="input-group input-group-sm" style="width: 150px;">
                    <input type="text" name="s" class="form-control pull-right" placeholder="Search" value="{{ isset($s) ? $s : old('s') }}">

                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                    </div>
                    <div class="input-group-btn">
                        <button type="button" class="btn btn-default pull-right"
                                onclick="location.href ='{{ route('permission.user.add') }}'">
                            <i class="fa fa-plus"></i>
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
                    <th>Nama</th>
                    <th>Email</th>
                    <th></th>
                </tr>
                @foreach ($data as $v)
                <tr>
                    <td>
                        {{ $v->name }}
                    </td>
                    <td>
                        {{ $v->email }}
                    </td>

                    <td>
                        <a class="btn btn-warning btn-xs" href="{{ route('permission.user.edit',['id' => $v->id ]) }}" style="float: left; margin-right: 5px;">Edit</a>
                        <a class="btn btn-danger btn-xs" href="{{ route('permission.user.reset',['id' => $v->id ]) }}" style="float: left; margin-right: 5px;">Reset</a>
                        <!--                            <form action="{{ url('/user/'.$v->id ) }}" method="POST">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-danger btn-xs">
                                                            Hapus
                                                        </button>
                                                    </form>-->
                    </td>

                </tr>
                @endforeach
            </tbody></table>
    </div>
    <!-- /.box-body -->
</div>

@stop