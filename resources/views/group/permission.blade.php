

@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
<h1>Group</h1>
@stop

@section('content')
<div class="box box-info">
{!! Form::open( array('route' => 'permission.group.storepermission', 'method'=>'post', 'class' => 'form-horizontal') ) !!}

    <div class="box-header with-border">
        <h3 class="box-title">Horizontal Form</h3>
    </div>
    <div class="box-body">
    
    <fieldset>
        <!-- Multiple Checkboxes -->
        <div class="form-group row">
            <label class="col-md-3 control-label" for="permissions">Role Permissions</label>
            <div class="col-md-9">
                @foreach($allPermissions as $perm)
                <div class="checkbox">
                    <label>
                        {!! Form::checkbox('perms[]', $perm->id, $perm->centang, []) !!} {{ $perm->description  }}
                    </label>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Button -->
        

    </fieldset>
    </div>
    <div class="box-footer">
        <div class="form-group row">
            <div class="col-md-12">
                {{ Form::hidden('group_id',$group->id) }}
                <button type="submit" id="savebutton" name="savebutton" class="btn btn-success">Simpan</button>
                <button onclick="location.href ='{{ route('permission.group.index') }}'" type="button" class="btn btn-dark">Kembali</button>
            </div>
        </div>
    </div>

{{ Form::close() }}
</div>
</div>


@stop