<!-- Id Field -->
<div class="form-group">
    {!! Form::label('id', 'Id:') !!}
    <p>{!! $packageLog->id !!}</p>
</div>

<!-- Package Name Field -->
<div class="form-group">
    {!! Form::label('package_name', 'Package Name:') !!}
    <p>{!! $packageLog->package_name !!}</p>
</div>

<!-- Price Field -->
<div class="form-group">
    {!! Form::label('price', 'Price:') !!}
    <p>{!! $packageLog->price !!}</p>
</div>

<!-- Admin Id Field -->
<div class="form-group">
    {!! Form::label('admin_id', 'Admin Id:') !!}
    <p>{!! $packageLog->admin_id !!}</p>
</div>

<!-- Type Field -->
<div class="form-group">
    {!! Form::label('type', 'Type:') !!}
    <p>{!! $packageLog->type !!}</p>
</div>

<!-- Created At Field -->
<div class="form-group">
    {!! Form::label('created_at', 'Created At:') !!}
    <p>{!! $packageLog->created_at !!}</p>
</div>

<!-- Updated At Field -->
<div class="form-group">
    {!! Form::label('updated_at', 'Updated At:') !!}
    <p>{!! $packageLog->updated_at !!}</p>
</div>

