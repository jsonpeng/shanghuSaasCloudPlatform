<!-- Order User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_user_id', 'Order User Id:') !!}
    {!! Form::number('order_user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- User Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_id', 'User Id:') !!}
    {!! Form::number('user_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_id', 'Order Id:') !!}
    {!! Form::number('order_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Commission Field -->
<div class="form-group col-sm-6">
    {!! Form::label('commission', 'Commission:') !!}
    {!! Form::text('commission', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Money Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_money', 'Order Money:') !!}
    {!! Form::text('order_money', null, ['class' => 'form-control']) !!}
</div>

<!-- User Dis Level Field -->
<div class="form-group col-sm-6">
    {!! Form::label('user_dis_level', 'User Dis Level:') !!}
    {!! Form::number('user_dis_level', null, ['class' => 'form-control']) !!}
</div>

<!-- Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('status', 'Status:') !!}
    {!! Form::text('status', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('distributionLogs.index') !!}" class="btn btn-default">Cancel</a>
</div>
