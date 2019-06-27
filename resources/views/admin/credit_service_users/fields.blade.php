<!-- Credit Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('credit_service_id', 'Credit Service Id:') !!}
    {!! Form::text('credit_service_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Service Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('service_id', 'Service Id:') !!}
    {!! Form::text('service_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Snumber Field -->
<div class="form-group col-sm-6">
    {!! Form::label('snumber', 'Snumber:') !!}
    {!! Form::text('snumber', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::text('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Pick Time Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pick_time', 'Pick Time:') !!}
    {!! Form::text('pick_time', null, ['class' => 'form-control']) !!}
</div>

<!-- Pick Shop Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('pick_shop_id', 'Pick Shop Id:') !!}
    {!! Form::text('pick_shop_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('creditServiceUsers.index') !!}" class="btn btn-default">Cancel</a>
</div>
