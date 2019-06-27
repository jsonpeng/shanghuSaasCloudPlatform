<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $role->id !!}</p>
</div>

<!-- Name Field -->
<div class="form-group">
    {!! Form::label('name', '名称:') !!}
    <p>{!! $role->name !!}</p>
</div>


<!-- Sort Field -->
<div class="form-group">
    {!! Form::label('sort', '描述:') !!}
    <p>{!! $role->description !!}</p>
</div>

<div class="form-group">
    {!! Form::label('permission', '用户权限:') !!}
    <div>
    @foreach ($permissions as $element)
        <div style="display: inline-block; margin-right: 20px;">{{$element->display_name}}</div>
    @endforeach
    </div>
</div>


<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $role->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $role->updated_at !!}</p>
</div>

