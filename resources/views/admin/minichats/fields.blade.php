<!-- App Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('app_id', 'App Id:') !!}
    {!! Form::text('app_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Access Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('access_token', 'Access Token:') !!}
    {!! Form::text('access_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Expires Field -->
<div class="form-group col-sm-6">
    {!! Form::label('expires', 'Expires:') !!}
    {!! Form::text('expires', null, ['class' => 'form-control']) !!}
</div>

<!-- Refresh Token Field -->
<div class="form-group col-sm-6">
    {!! Form::label('refresh_token', 'Refresh Token:') !!}
    {!! Form::text('refresh_token', null, ['class' => 'form-control']) !!}
</div>

<!-- Admin Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('admin_id', 'Admin Id:') !!}
    {!! Form::number('admin_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('minichats.index') !!}" class="btn btn-default">Cancel</a>
</div>
