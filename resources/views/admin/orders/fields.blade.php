<!-- Customer Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('customer_id', 'Customer Id:') !!}
    {!! Form::number('customer_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Address Id Field -->
<div class="form-group col-sm-6">
    {!! Form::label('address_id', 'Address Id:') !!}
    {!! Form::number('address_id', null, ['class' => 'form-control']) !!}
</div>

<!-- Price Field -->
<div class="form-group col-sm-6">
    {!! Form::label('price', 'Price:') !!}
    {!! Form::text('price', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Status Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_status', 'Order Status:') !!}
    {!! Form::text('order_status', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Delivery Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_delivery', 'Order Delivery:') !!}
    {!! Form::text('order_delivery', null, ['class' => 'form-control']) !!}
</div>

<!-- Order Pay Field -->
<div class="form-group col-sm-6">
    {!! Form::label('order_pay', 'Order Pay:') !!}
    {!! Form::text('order_pay', null, ['class' => 'form-control']) !!}
</div>

<!-- Remark Field -->
<div class="form-group col-sm-6">
    {!! Form::label('remark', 'Remark:') !!}
    {!! Form::text('remark', null, ['class' => 'form-control']) !!}
</div>

<!-- Submit Field -->
<div class="form-group col-sm-12">
    {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
    <a href="{!! route('orders.index') !!}" class="btn btn-default">Cancel</a>
</div>
