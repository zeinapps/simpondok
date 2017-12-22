

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>User INDEx</h1>
@stop

@section('content')

<div class="box box-info">
    {!! Form::open( array('route' => 'permission.role.storepermission', 'method'=>'post') ) !!}

    <div class="box-body">


        <div class="form-group">
            @foreach($allGroup as $group)
            <label class="col-md-4 control-label" for="permissions">{{ $group->name }}</label>
            <div class="col-md-8">
                @foreach($allPermissions as $perm)
                @if($group->id == $perm->group_id)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('perms[]', $perm->id, $perm->centang, []) !!} {{ $perm->description  }}
                    </label>
                </div>
                @endif
                @endforeach
            </div>
            <hr width="100%">
            @endforeach
        </div>

        <!-- /.box-body -->



    </div>

    <div class="box-footer">
        {{ Form::hidden('role_id',$role->id) }}
        <button type="submit" id="savebutton" name="savebutton" class="btn btn-success">Simpan
        </button>
        <button onclick="location.href ='{{ route('permission.role.index') }}'" type="button"
                class="btn btn-dark">Kembali
        </button>
    </div>

    {!! Form::close() !!}
</div>
@stop