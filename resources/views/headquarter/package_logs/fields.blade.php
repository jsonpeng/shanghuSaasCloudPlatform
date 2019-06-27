<!-- Package Name Field -->
<div class="form-group col-sm-6">
    {!! Form::label('package_name', 'Package Name:') !!}
    {!! Form::text('package_name', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Admin Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('admin_id', 'Admin Id:') !!}
    {!! Form::text('admin_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Type Field -->
<div class="form-group col-sm-6">
    {!! Form::label('type', 'Type:') !!}
    {!! Form::text('type', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('packageLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
