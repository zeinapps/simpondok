

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Group Role</h1>
@stop

@section('content')

<div class="box box-info">
    {!! Form::open( array('route' => 'permission.role.storegroup', 'method'=>'post') ) !!}
    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div>
    <div class="box-body">

        <fieldset>
        <div class="form-group row">
            <label class="col-md-3 control-label" for="permissions">Permissions</label>
            <div class="col-md-9">
            @foreach($allGroups as $perm)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('perms[]', $perm->id, $perm->centang, []) !!} {{ $perm->description  }}
                    </label>
                </div>
            @endforeach
            </div>
        </div>
            </fieldset>
        <!-- /.box-body -->



    </div>

    <div class="box-footer">
        {{ Form::hidden('role_id',$role->id) }}
            <button type="submit" id="savebutton" name="savebutton" class="btn btn-success">Simpan</button>
            <button onclick="location.href='{{ route('permission.role.index') }}'" type="button" class="btn btn-dark">Kembali</button>
    </div>

    {!! Form::close() !!}
</div>
@stop